<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator;

use cebe\openapi\Reader;
use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Emit\ApiExceptionEmitter;
use Mlavrinenko\Paogen\Generator\Emit\ClientEmitter;
use Mlavrinenko\Paogen\Generator\Emit\EnumEmitter;
use Mlavrinenko\Paogen\Generator\Emit\ModelEmitter;
use Mlavrinenko\Paogen\Generator\Emit\OperationEmitter;
use Mlavrinenko\Paogen\Generator\Enum\EnumCatalog;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;
use Mlavrinenko\Paogen\Generator\Naming\NormalisationContext;
use Mlavrinenko\Paogen\Generator\Naming\NormaliserFactory;
use Mlavrinenko\Paogen\Generator\Naming\SymbolKind;

/**
 * Orchestrates a single generation run: schema + profile + bindings → files.
 */
final readonly class Generator
{
    private ModelPlanner $modelPlanner;

    public function __construct(
        private AttributeScanner $scanner,
        ModelEmitter $modelEmitter = new ModelEmitter(),
        private EnumEmitter $enumEmitter = new EnumEmitter(),
        private ApiExceptionEmitter $apiExceptionEmitter = new ApiExceptionEmitter(),
        private PlanApplier $applier = new PlanApplier(),
    ) {
        $this->modelPlanner = new ModelPlanner($modelEmitter);
    }

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

        $normaliser = NormaliserFactory::fromProfile($profile);
        $enums = new EnumCatalog($enumNamespace);
        $enumRegistry = new NameRegistry($normaliser);
        $this->collectComponentEnums($openApi, $enums, $enumRegistry);

        // Lazy-populated: every ref-resolution site routes through here
        // so each raw name is normalised exactly once and collisions are
        // caught the moment a second raw key tries to claim the same PHP
        // class.
        $registry = new NameRegistry($normaliser);

        /** @var array<string,string> $writes */
        $writes = [];

        $this->modelPlanner->plan($openApi, $modelNamespace, $modelDir, $registry, $bindings, $enums, $writes);
        $this->emitClient($openApi, $rootNamespace, $rootDir, $modelNamespace, $registry, $bindings, $enums, $writes);
        $this->emitApiException($rootNamespace, $rootDir, $writes);
        $this->emitEnums($enums, $enumDir, $writes);

        $prunes = $this->planPrunes($rootDir, $writes);

        return new GenerationPlan($writes, $prunes);
    }

    private function collectComponentEnums(OpenApi $openApi, EnumCatalog $enums, NameRegistry $enumRegistry): void
    {
        $components = $openApi->components;

        if ($components === null) {
            return;
        }

        /** @var array<string,Schema|Reference> $schemas */
        $schemas = $components->schemas ?? [];
        $context = new NormalisationContext(SymbolKind::SchemaComponent);

        foreach ($schemas as $name => $schema) {
            if (!$schema instanceof Schema) {
                continue;
            }

            $phpName = null;
            $rawSpec = EnumCatalog::specFromSchema($name, $schema);

            if (!$rawSpec instanceof \Mlavrinenko\Paogen\Generator\Enum\EnumSpec) {
                continue;
            }

            $phpName = $enumRegistry->resolve($name, $context);
            $spec = new \Mlavrinenko\Paogen\Generator\Enum\EnumSpec($phpName, $rawSpec->backingType, $rawSpec->cases);

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
     * @param array<string,string> $writes
     */
    private function emitClient(
        OpenApi $openApi,
        string $rootNamespace,
        string $rootDir,
        string $modelNamespace,
        NameRegistry $registry,
        Bindings $bindings,
        EnumCatalog $enums,
        array &$writes,
    ): void {
        if ($openApi->paths === null) {
            return;
        }

        $emitter = new ClientEmitter(new OperationEmitter($modelNamespace, $enums, $registry));
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
