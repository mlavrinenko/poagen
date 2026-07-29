<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator;

use cebe\openapi\json\JsonPointer;
use cebe\openapi\Reader;
use cebe\openapi\spec\OpenApi;
use Mlavrinenko\Paogen\Exception\UnrepresentableConstructsException;
use Mlavrinenko\Paogen\Generator\Emit\ApiExceptionEmitter;
use Mlavrinenko\Paogen\Generator\Emit\ClientEmitter;
use Mlavrinenko\Paogen\Generator\Emit\ComponentCatalog;
use Mlavrinenko\Paogen\Generator\Emit\DiscriminatorEnforcer;
use Mlavrinenko\Paogen\Generator\Emit\EnumEmitter;
use Mlavrinenko\Paogen\Generator\Emit\FormatAdvisor;
use Mlavrinenko\Paogen\Generator\Emit\InlinePayloadCatalog;
use Mlavrinenko\Paogen\Generator\Emit\InlinePayloadPlanner;
use Mlavrinenko\Paogen\Generator\Emit\ModelEmitter;
use Mlavrinenko\Paogen\Generator\Emit\ModelNameLedger;
use Mlavrinenko\Paogen\Generator\Emit\OperationEmitter;
use Mlavrinenko\Paogen\Generator\Emit\OperationIdAdvisor;
use Mlavrinenko\Paogen\Generator\Emit\SkippedComponent;
use Mlavrinenko\Paogen\Generator\Emit\TypeListScanner;
use Mlavrinenko\Paogen\Generator\Enum\ComponentEnumCollector;
use Mlavrinenko\Paogen\Generator\Enum\EnumCatalog;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;
use Mlavrinenko\Paogen\Generator\Naming\NormaliserFactory;

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
        private SkipListValidator $skipListValidator = new SkipListValidator(),
        private ProfileTargetValidator $profileTargets = new ProfileTargetValidator(),
    ) {
        $this->modelPlanner = new ModelPlanner($modelEmitter);
    }

    public function generate(Profile $profile): GenerationPlan
    {
        $plan = $this->plan($profile);
        $this->applier->apply($plan);

        return $plan;
    }

    /**
     * Build the complete set of would-be writes and prunes without
     * touching disk. Called by {@see generate} and by the CLI
     * `--dry-run` / `--diff` flags.
     *
     * Plans fully before failing: every construct the generator cannot
     * represent is collected, not just the first one, and cross-checked
     * against `Profile::$skip` once at the end. If anything remains
     * unaccounted for, this throws {@see UnrepresentableConstructsException}
     * and returns nothing — the plan-then-write split means {@see generate}
     * never reaches the apply step, so nothing is written to disk
     * (abort-on-unrepresentable-constructs).
     */
    public function plan(Profile $profile): GenerationPlan
    {
        $bindings = $this->scanner->scan($profile);

        // Keep $ref nodes as Reference objects so the emitter can resolve them
        // to typed cross-class references.
        $openApi = Reader::readFromYamlFile($profile->schema, OpenApi::class, false);
        // Populate JSON-pointer document positions — independent of
        // reference resolution — so diagnostics can point at the exact
        // schema node responsible.
        $openApi->setDocumentContext($openApi, new JsonPointer(''));

        // ADR-010 + T-030 + abort-on-unrepresentable-constructs: collect
        // every property-level `oneOf`/`anyOf` union with no discriminator
        // (after applying any profile-level override), instead of failing
        // on the first one found.
        $discriminatorSkips = new DiscriminatorEnforcer($profile->discriminators)->enforce($openApi);

        // Same discipline, one construct further out: a `type` list naming
        // several types PHP cannot express as one (nullable-type-arrays).
        $typeListSkips = TypeListScanner::scan($openApi);

        $rootNamespace = rtrim($profile->namespace, '\\') . '\\Generated';
        $modelNamespace = $rootNamespace . '\\Model';
        $enumNamespace = $rootNamespace . '\\Enum';
        $rootDir = rtrim($profile->output, \DIRECTORY_SEPARATOR) . \DIRECTORY_SEPARATOR . 'Generated';
        $modelDir = $rootDir . \DIRECTORY_SEPARATOR . 'Model';
        $enumDir = $rootDir . \DIRECTORY_SEPARATOR . 'Enum';

        $normaliser = NormaliserFactory::fromProfile($profile);
        $enums = new EnumCatalog($enumNamespace);
        $enumRegistry = new NameRegistry($normaliser);
        new ComponentEnumCollector()->collect($openApi, $enums, $enumRegistry);

        // Lazy-populated: every ref-resolution site routes through here
        // so each raw name is normalised exactly once and collisions are
        // caught the moment a second raw key tries to claim the same PHP
        // class.
        $registry = new NameRegistry($normaliser);
        // Sibling registry scoped to the ApiClient — operationIds form
        // their own collision space (PHP method names on one class)
        // separate from schema-component class names.
        $operationIdRegistry = new NameRegistry($normaliser);

        /** @var array<string,string> $writes */
        $writes = [];

        $components = ComponentCatalog::build($openApi, $registry, $enums);
        $excludedComponents = array_fill_keys(
            array_map(
                static fn(SkippedComponent $c): string => $c->rawName,
                [...$discriminatorSkips, ...$typeListSkips['components']],
            ),
            true,
        );
        $preScannedSkips = [];

        foreach ($typeListSkips['operations'] as $skip) {
            $preScannedSkips[$skip->operationId] = $skip->reason;
        }

        // Payload classes are named before anything is emitted, because both
        // halves of the run need the same answer: the model planner emits them,
        // and the operation emitter points its parameters and return types at
        // them (inline-body-and-response-schemas).
        $ledger = new ModelNameLedger();
        $inlinePayloads = InlinePayloadPlanner::build($openApi, $operationIdRegistry, $profile->inlineModels, $ledger);

        $this->modelPlanner->plan(
            $openApi,
            $modelNamespace,
            $modelDir,
            $registry,
            $bindings,
            $enums,
            $writes,
            $components,
            $excludedComponents,
            $inlinePayloads->roots(),
            $ledger,
        );
        $skipped = $this->emitClient($openApi, $rootNamespace, $rootDir, $modelNamespace, $registry, $operationIdRegistry, $normaliser, $bindings, $enums, $components, $inlinePayloads, $preScannedSkips, $writes);
        $this->emitApiException($rootNamespace, $rootDir, $writes);
        $this->emitEnums($enums, $enumDir, $writes);

        $prunes = $this->planPrunes($rootDir, $writes);
        $notices = [
            ...OperationIdAdvisor::notices($openApi, $profile->methodRenames),
            ...FormatAdvisor::notices($openApi, $bindings),
        ];
        $skippedComponents = [...$components->skipped(), ...$discriminatorSkips, ...$typeListSkips['components']];

        $failures = [
            ...$this->skipListValidator->validate($openApi, $components, $profile->skip, $skipped, $skippedComponents),
            ...$this->profileTargets->validate($openApi, $profile->inlineModels, $profile->methodRenames),
        ];

        if ($failures !== []) {
            throw UnrepresentableConstructsException::forProblems($failures);
        }

        return new GenerationPlan($writes, $prunes, $skipped, $skippedComponents, $notices);
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
     * @param  array<string,string>                                $preScannedSkips raw operationId → reason
     * @param  array<string,string>                                $writes
     * @return list<\Mlavrinenko\Paogen\Generator\Emit\SkippedOperation>
     */
    private function emitClient(
        OpenApi $openApi,
        string $rootNamespace,
        string $rootDir,
        string $modelNamespace,
        NameRegistry $registry,
        NameRegistry $operationIdRegistry,
        \Mlavrinenko\Paogen\Generator\Naming\NameNormaliser $normaliser,
        Bindings $bindings,
        EnumCatalog $enums,
        ComponentCatalog $components,
        InlinePayloadCatalog $inlinePayloads,
        array $preScannedSkips,
        array &$writes,
    ): array {
        if ($openApi->paths === null) {
            return [];
        }

        $emitter = new ClientEmitter(new OperationEmitter(
            $modelNamespace,
            $enums,
            $registry,
            $operationIdRegistry,
            $normaliser,
            components: $components,
            inlinePayloads: $inlinePayloads,
            preScannedSkips: $preScannedSkips,
        ));
        $code = $emitter->emit($rootNamespace, 'ApiClient', $openApi, $bindings);

        if ($code === null) {
            return $emitter->drainSkipped();
        }

        $writes[$rootDir . \DIRECTORY_SEPARATOR . 'ApiClient.php'] = $code;

        return $emitter->drainSkipped();
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
