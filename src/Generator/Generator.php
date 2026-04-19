<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator;

use cebe\openapi\Reader;
use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Emit\ClientEmitter;
use Mlavrinenko\Paogen\Generator\Emit\EnumEmitter;
use Mlavrinenko\Paogen\Generator\Emit\ModelEmitter;
use Mlavrinenko\Paogen\Generator\Emit\OperationEmitter;
use Mlavrinenko\Paogen\Generator\Enum\EnumCatalog;

/**
 * Orchestrates a single generation run: schema + profile + bindings → files.
 */
final readonly class Generator
{
    public function __construct(
        private AttributeScanner $scanner,
        private ModelEmitter $modelEmitter = new ModelEmitter(),
        private EnumEmitter $enumEmitter = new EnumEmitter(),
    ) {}

    public function generate(Profile $profile): void
    {
        $bindings = $this->scanner->scan($profile);

        // Keep $ref nodes as Reference objects so the emitter can resolve them
        // to typed cross-class references.
        $openApi = Reader::readFromYamlFile($profile->schema, OpenApi::class, false);

        $rootNamespace = rtrim($profile->namespace, '\\') . '\\Generated';
        $modelNamespace = $rootNamespace . '\\Model';
        $enumNamespace = $rootNamespace . '\\Enum';
        $rootDir = rtrim($profile->output, \DIRECTORY_SEPARATOR) . \DIRECTORY_SEPARATOR . 'Generated';
        $modelDir = $rootDir . \DIRECTORY_SEPARATOR . 'Model';
        $enumDir = $rootDir . \DIRECTORY_SEPARATOR . 'Enum';

        $this->ensureDir($modelDir);

        $enums = new EnumCatalog($enumNamespace);
        $this->collectComponentEnums($openApi, $enums);

        /** @var array<string,true> $emitted */
        $emitted = [];

        $this->emitModels($openApi, $modelNamespace, $modelDir, $profile->renames, $bindings, $enums, $emitted);
        $this->emitClient($openApi, $rootNamespace, $rootDir, $modelNamespace, $bindings, $enums, $emitted);
        $this->emitEnums($enums, $enumDir, $emitted);

        $this->pruneStale($rootDir, $emitted);
    }

    private function collectComponentEnums(OpenApi $openApi, EnumCatalog $enums): void
    {
        $components = $openApi->components;

        if ($components === null) {
            return;
        }

        /** @var array<string,Schema|Reference> $schemas */
        $schemas = $components->schemas ?? [];

        foreach ($schemas as $name => $schema) {
            if (!$schema instanceof Schema) {
                continue;
            }

            $spec = EnumCatalog::specFromSchema($name, $schema);

            if (!$spec instanceof \Mlavrinenko\Paogen\Generator\Enum\EnumSpec) {
                continue;
            }

            $enums->registerComponent($name, $spec);
        }
    }

    /**
     * @param array<string,true> $emitted
     */
    private function emitEnums(EnumCatalog $enums, string $enumDir, array &$emitted): void
    {
        $specs = $enums->all();

        if ($specs === []) {
            return;
        }

        $this->ensureDir($enumDir);

        foreach ($specs as $spec) {
            $code = $this->enumEmitter->emit($enums->enumNamespace, $spec);
            $path = $enumDir . \DIRECTORY_SEPARATOR . $spec->name . '.php';
            file_put_contents($path, $code);
            $emitted[$path] = true;
        }
    }

    /**
     * @param array<string,string> $renames
     * @param array<string,true>   $emitted
     */
    private function emitModels(
        OpenApi $openApi,
        string $modelNamespace,
        string $modelDir,
        array $renames,
        Bindings $bindings,
        EnumCatalog $enums,
        array &$emitted,
    ): void {
        $components = $openApi->components;

        if ($components === null) {
            return;
        }

        /** @var array<string,Schema|Reference> $schemas */
        $schemas = $components->schemas ?? [];
        $names = array_keys($schemas);
        sort($names, \SORT_STRING);

        /** @var list<\Mlavrinenko\Paogen\Generator\Emit\SynthesisedModel> $pending */
        $pending = [];

        foreach ($names as $rawName) {
            $schema = $schemas[$rawName];

            if (!$schema instanceof Schema) {
                continue;
            }

            if ($schema->type !== 'object') {
                continue;
            }

            $className = $renames[$rawName] ?? $rawName;
            $emission = $this->modelEmitter->emit($modelNamespace, $className, $schema, $bindings, $enums);

            $path = $modelDir . \DIRECTORY_SEPARATOR . $className . '.php';
            file_put_contents($path, $emission->source);
            $emitted[$path] = true;

            foreach ($emission->children as $child) {
                $pending[] = $child;
            }
        }

        $this->drainSynthesisedChildren($pending, $modelNamespace, $modelDir, $bindings, $enums, $emitted);
    }

    /**
     * Drain the FIFO queue of synthesised inline-object classes (T-013).
     *
     * Each emission may itself queue grandchildren; keep going until the
     * queue is empty. Sorting by name at each batch keeps byte-stability
     * across runs regardless of the order children were discovered.
     *
     * @param list<\Mlavrinenko\Paogen\Generator\Emit\SynthesisedModel> $pending
     * @param array<string,true> $emitted
     */
    private function drainSynthesisedChildren(
        array $pending,
        string $modelNamespace,
        string $modelDir,
        Bindings $bindings,
        EnumCatalog $enums,
        array &$emitted,
    ): void {
        while ($pending !== []) {
            usort(
                $pending,
                static fn(\Mlavrinenko\Paogen\Generator\Emit\SynthesisedModel $a, \Mlavrinenko\Paogen\Generator\Emit\SynthesisedModel $b): int => strcmp($a->name, $b->name),
            );

            $batch = $pending;
            $pending = [];

            foreach ($batch as $child) {
                $emission = $this->modelEmitter->emit($modelNamespace, $child->name, $child->schema, $bindings, $enums);
                $path = $modelDir . \DIRECTORY_SEPARATOR . $child->name . '.php';
                file_put_contents($path, $emission->source);
                $emitted[$path] = true;

                foreach ($emission->children as $grand) {
                    $pending[] = $grand;
                }
            }
        }
    }

    /**
     * @param array<string,true> $emitted
     */
    private function emitClient(
        OpenApi $openApi,
        string $rootNamespace,
        string $rootDir,
        string $modelNamespace,
        Bindings $bindings,
        EnumCatalog $enums,
        array &$emitted,
    ): void {
        if ($openApi->paths === null) {
            return;
        }

        $emitter = new ClientEmitter(new OperationEmitter($modelNamespace, $enums));
        $code = $emitter->emit($rootNamespace, 'ApiClient', $openApi, $bindings);

        $path = $rootDir . \DIRECTORY_SEPARATOR . 'ApiClient.php';

        if ($code === null) {
            return;
        }

        $this->ensureDir($rootDir);

        file_put_contents($path, $code);
        $emitted[$path] = true;
    }

    /**
     * Delete any file under `Generated/` that the current run did not emit.
     *
     * Guarded strictly to the `Generated/` subtree so user code alongside
     * it is never touched. Silently skipped if the root does not yet
     * exist (first-ever run).
     *
     * @param array<string,true> $emitted
     */
    private function pruneStale(string $rootDir, array $emitted): void
    {
        if (!is_dir($rootDir)) {
            return;
        }

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($rootDir, \FilesystemIterator::SKIP_DOTS),
        );

        foreach ($iterator as $entry) {
            \assert($entry instanceof \SplFileInfo);

            if (!$entry->isFile()) {
                continue;
            }

            $path = $entry->getPathname();

            if (!isset($emitted[$path])) {
                unlink($path);
            }
        }
    }

    private function ensureDir(string $dir): void
    {
        if (!is_dir($dir) && !mkdir($dir, 0o755, true) && !is_dir($dir)) {
            throw new \RuntimeException("Could not create output dir: {$dir}");
        }
    }
}
