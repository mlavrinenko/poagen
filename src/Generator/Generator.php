<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator;

use cebe\openapi\Reader;
use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Emit\ApiExceptionEmitter;
use Mlavrinenko\Paogen\Generator\Emit\ClientEmitter;
use Mlavrinenko\Paogen\Generator\Emit\CompositionResolver;
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
        private ApiExceptionEmitter $apiExceptionEmitter = new ApiExceptionEmitter(),
        private PlanApplier $applier = new PlanApplier(),
    ) {}

    public function generate(Profile $profile): void
    {
        $this->applier->apply($this->plan($profile));
    }

    /**
     * Build the complete set of would-be writes and prunes without
     * touching disk. Called by {@see generate} and by the CLI
     * `--dry-run` / `--diff` flags.
     */
    public function plan(Profile $profile): GenerationPlan
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

        $enums = new EnumCatalog($enumNamespace);
        $this->collectComponentEnums($openApi, $enums);

        /** @var array<string,string> $writes */
        $writes = [];

        $this->emitModels($openApi, $modelNamespace, $modelDir, $profile->renames, $bindings, $enums, $writes);
        $this->emitClient($openApi, $rootNamespace, $rootDir, $modelNamespace, $bindings, $enums, $writes);
        $this->emitApiException($rootNamespace, $rootDir, $writes);
        $this->emitEnums($enums, $enumDir, $writes);

        $prunes = $this->planPrunes($rootDir, $writes);

        return new GenerationPlan($writes, $prunes);
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
     * @param array<string,string> $writes
     */
    private function emitEnums(EnumCatalog $enums, string $enumDir, array &$writes): void
    {
        $specs = $enums->all();

        if ($specs === []) {
            return;
        }

        foreach ($specs as $spec) {
            $code = $this->enumEmitter->emit($enums->enumNamespace, $spec);
            $path = $enumDir . \DIRECTORY_SEPARATOR . $spec->name . '.php';
            $writes[$path] = $code;
        }
    }

    /**
     * @param array<string,string> $renames
     * @param array<string,string> $writes
     */
    private function emitModels(
        OpenApi $openApi,
        string $modelNamespace,
        string $modelDir,
        array $renames,
        Bindings $bindings,
        EnumCatalog $enums,
        array &$writes,
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

            $effective = $this->materialiseAllOf($schema, $openApi);

            if ($effective->type !== 'object') {
                continue;
            }

            $className = $renames[$rawName] ?? $rawName;
            $emission = $this->modelEmitter->emit($modelNamespace, $className, $effective, $bindings, $enums);

            $path = $modelDir . \DIRECTORY_SEPARATOR . $className . '.php';
            $writes[$path] = $emission->source;

            foreach ($emission->children as $child) {
                $pending[] = $child;
            }
        }

        $this->drainSynthesisedChildren($pending, $modelNamespace, $modelDir, $bindings, $enums, $writes);
    }

    /**
     * Flatten a top-level `allOf` schema into a single object-type Schema
     * whose `properties`/`required` are the union of its branches (T-008).
     * Non-`allOf` schemas pass through untouched.
     */
    private function materialiseAllOf(Schema $schema, OpenApi $openApi): Schema
    {
        if (!\is_array($schema->allOf) || $schema->allOf === []) {
            return $schema;
        }

        $flattened = CompositionResolver::flattenAllOf($schema, $openApi);

        return $flattened ?? $schema;
    }

    /**
     * Drain the FIFO queue of synthesised inline-object classes (T-013).
     *
     * Each emission may itself queue grandchildren; keep going until the
     * queue is empty. Sorting by name at each batch keeps byte-stability
     * across runs regardless of the order children were discovered.
     *
     * @param list<\Mlavrinenko\Paogen\Generator\Emit\SynthesisedModel> $pending
     * @param array<string,string> $writes
     */
    private function drainSynthesisedChildren(
        array $pending,
        string $modelNamespace,
        string $modelDir,
        Bindings $bindings,
        EnumCatalog $enums,
        array &$writes,
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
                $writes[$path] = $emission->source;

                foreach ($emission->children as $grand) {
                    $pending[] = $grand;
                }
            }
        }
    }

    /**
     * @param array<string,string> $writes
     */
    private function emitClient(
        OpenApi $openApi,
        string $rootNamespace,
        string $rootDir,
        string $modelNamespace,
        Bindings $bindings,
        EnumCatalog $enums,
        array &$writes,
    ): void {
        if ($openApi->paths === null) {
            return;
        }

        $emitter = new ClientEmitter(new OperationEmitter($modelNamespace, $enums));
        $code = $emitter->emit($rootNamespace, 'ApiClient', $openApi, $bindings);

        if ($code === null) {
            return;
        }

        $writes[$rootDir . \DIRECTORY_SEPARATOR . 'ApiClient.php'] = $code;
    }

    /** @param array<string,string> $writes */
    private function emitApiException(string $rootNamespace, string $rootDir, array &$writes): void
    {
        // Only emit when ApiClient was emitted: the exception has no
        // referent without at least one operation that throws it.
        if (!isset($writes[$rootDir . \DIRECTORY_SEPARATOR . 'ApiClient.php'])) {
            return;
        }
        $writes[$rootDir . \DIRECTORY_SEPARATOR . 'ApiException.php'] = $this->apiExceptionEmitter->emit($rootNamespace);
    }

    /**
     * List every file under `Generated/` that the current run did not
     * emit. Guarded strictly to the `Generated/` subtree so user code
     * alongside it is never touched. Returns an empty list if the root
     * does not yet exist (first-ever run).
     *
     * @param  array<string,string> $writes
     * @return list<string>
     */
    private function planPrunes(string $rootDir, array $writes): array
    {
        if (!is_dir($rootDir)) {
            return [];
        }

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($rootDir, \FilesystemIterator::SKIP_DOTS),
        );

        /** @var list<string> $prunes */
        $prunes = [];

        foreach ($iterator as $entry) {
            \assert($entry instanceof \SplFileInfo);

            if (!$entry->isFile()) {
                continue;
            }

            $path = $entry->getPathname();

            if (!isset($writes[$path])) {
                $prunes[] = $path;
            }
        }

        return $prunes;
    }
}
