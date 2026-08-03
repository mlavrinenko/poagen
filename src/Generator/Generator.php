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
use Mlavrinenko\Paogen\Generator\Emit\GeneratedFileHeader;
use Mlavrinenko\Paogen\Generator\Emit\InlinePayloadCatalog;
use Mlavrinenko\Paogen\Generator\Emit\InlinePayloadPlanner;
use Mlavrinenko\Paogen\Generator\Emit\ModelEmitter;
use Mlavrinenko\Paogen\Generator\Emit\ModelNameLedger;
use Mlavrinenko\Paogen\Generator\Emit\OperationEmitter;
use Mlavrinenko\Paogen\Generator\Emit\OperationIdAdvisor;
use Mlavrinenko\Paogen\Generator\Emit\QuerySerializationAdvisor;
use Mlavrinenko\Paogen\Generator\Emit\SchemalessBodyAdvisor;
use Mlavrinenko\Paogen\Generator\Emit\SchemaScan;
use Mlavrinenko\Paogen\Generator\Emit\SecurityAudit;
use Mlavrinenko\Paogen\Generator\Emit\ServerCatalog;
use Mlavrinenko\Paogen\Generator\Emit\SkippedComponent;
use Mlavrinenko\Paogen\Generator\Emit\SkippedOperation;
use Mlavrinenko\Paogen\Generator\Emit\TypeListScanner;
use Mlavrinenko\Paogen\Generator\Emit\UnconstrainedFieldAdvisor;
use Mlavrinenko\Paogen\Generator\Emit\UnionCatalog;
use Mlavrinenko\Paogen\Generator\Emit\UnsupportedKeywordScanner;
use Mlavrinenko\Paogen\Generator\Enum\ComponentEnumCollector;
use Mlavrinenko\Paogen\Generator\Enum\EnumCatalog;
use Mlavrinenko\Paogen\Generator\Naming\NameNormaliser;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;
use Mlavrinenko\Paogen\Generator\Naming\NormaliserFactory;

use const DIRECTORY_SEPARATOR;

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
        private PropertyRenameValidator $propertyRenameValidator = new PropertyRenameValidator(),
        private UnionGuidanceValidator $unionGuidance = new UnionGuidanceValidator(),
        private PrunePlanner $prunePlanner = new PrunePlanner(),
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

        // A `security` requirement naming a scheme the document never
        // declared is a gap only the consumer can fill, so their declaration
        // is merged in before anything reads the document. The audit then
        // judges what is still undeclared, what paogen refuses to wire, and
        // what it can only report.
        $profileSecurityFailures = ProfileSecuritySchemes::apply($openApi, $profile->securitySchemes);
        $security = SecurityAudit::of($openApi);

        // declare-an-undiscriminated-union-as-raw-data: resolve every
        // property-level `oneOf`/`anyOf` through the four layers — a tag in the
        // value, a tag on the enclosing object, a discriminating field computed
        // from the branches, a profile pin — and collect what none of them
        // reaches instead of failing on the first
        // (abort-on-unrepresentable-constructs). Mutates the document, so it
        // runs before anything reads a property's branch list, and rides to the
        // emitters on $bindings.
        $unions = new DiscriminatorEnforcer($profile->discriminators, $profile)->enforce($openApi);
        $bindings = $bindings->withUnions($unions);

        // Same discipline, one walk further out: a `type` list naming several types PHP cannot
        // express as one (nullable-type-arrays), and a JSON Schema 2020-12 keyword no emitter
        // implements (swap-openapi-parser-for-31-support). One walk, two probes, one reason each.
        $schemaSkips = SchemaScan::run($openApi, [
            TypeListScanner::probe(...),
            UnsupportedKeywordScanner::probe(...),
        ]);

        $rootNamespace = rtrim($profile->namespace, '\\') . '\\Generated';
        $modelNamespace = $rootNamespace . '\\Model';
        $enumNamespace = $rootNamespace . '\\Enum';
        $rootDir = rtrim($profile->output, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'Generated';
        $modelDir = $rootDir . DIRECTORY_SEPARATOR . 'Model';
        $enumDir = $rootDir . DIRECTORY_SEPARATOR . 'Enum';

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
                [...$unions->failures(), ...$schemaSkips['components']],
            ),
            true,
        );
        $preScannedSkips = [];

        foreach ($schemaSkips['operations'] as $skip) {
            $preScannedSkips[$skip->operationId] = $skip->reason;
        }

        // Payload classes are named before anything is emitted: the model planner emits them, and
        // the operation emitter points its parameters and return types at them (inline-body-and-response-schemas).
        $ledger = new ModelNameLedger();
        $inlinePayloads = InlinePayloadPlanner::build($openApi, $operationIdRegistry, $registry, $profile->inlineModels, $ledger, $profile->xmlElements, $preScannedSkips, $profile->unionPins);

        // See UnionCatalog::merge() for why the response-position half waits for this walk.
        $unions = UnionCatalog::merge($unions, $inlinePayloads->responseUnions());

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
            $profile->propertyRenames,
        );
        $tagRegistry = new NameRegistry($normaliser);
        $skipped = $this->emitClient($openApi, $rootNamespace, $rootDir, $modelNamespace, $registry, $operationIdRegistry, $normaliser, $bindings, $enums, $components, $inlinePayloads, $preScannedSkips, $profile, $tagRegistry, $writes);
        $this->apiExceptionEmitter->emitInto($rootNamespace, $rootDir, $writes);
        $this->enumEmitter->emitAllInto($enums, $enumDir, $writes);

        $prunes = $this->prunePlanner->plan($rootDir, $writes);
        $notices = [
            ...OperationIdAdvisor::notices($openApi, $profile->methodRenames),
            ...FormatAdvisor::notices($openApi, $bindings),
            // Where a `mixed` survives, the vendor declared nothing there and
            // the run says so — `declared-shapes-become-types` tolerates that
            // one `mixed` only while it is visible.
            ...UnconstrainedFieldAdvisor::notices($openApi),
            ...SchemalessBodyAdvisor::notices($openApi),
            // One line per union naming what it will discriminate on, so the
            // rule is visible before anything runs rather than discovered in
            // production — and so a pin's narrowing is reprinted on every run,
            // not only the one that added it.
            ...$unions->notices(),
            ...$security->notices,
            // A list-valued query parameter's repeated-key wire form is
            // correct whether the document spelled out `style`/`explode` or
            // left the OpenAPI default to apply — but silently is not the
            // same as visibly, `support-the-parameter-shapes-real-documents-use`.
            ...QuerySerializationAdvisor::notices($openApi),
        ];
        $skippedComponents = [...$components->skipped(), ...$unions->failures(), ...$schemaSkips['components']];

        $failures = [
            ...$profileSecurityFailures,
            ...$security->failures,
            ...UnsupportedKeywordScanner::webhookFailures($openApi),
            ...ServerCatalog::variableProblems($openApi),
            ...$this->skipListValidator->validate($openApi, $components, $profile->skip, $skipped, $skippedComponents),
            ...$this->profileTargets->validate($openApi, $profile->inlineModels, $profile->methodRenames, $profile),
            ...$this->propertyRenameValidator->validate($openApi, $components, $profile->propertyRenames),
            ...$this->unionGuidance->validate($openApi, $profile, $unions, $operationIdRegistry),
        ];

        if ($failures !== []) {
            throw UnrepresentableConstructsException::forProblems($failures);
        }

        // Stamped once over the finished write set rather than inside each of
        // the emitters: every file paogen emits carries the header, and a
        // per-emitter copy would be a rule the next emitter could forget.
        // Stamping inside the plan rather than in {@see PlanApplier} is what
        // makes `--diff` and `--dry-run` show the same bytes a real run writes.
        $header = new GeneratedFileHeader($profile->source);
        $writes = array_map($header->stamp(...), $writes);

        return new GenerationPlan($writes, $prunes, $skipped, $skippedComponents, $notices);
    }

    /**
     * @param  array<string,string>                                $preScannedSkips raw operationId → reason
     * @param  array<string,string>                                $writes
     * @return list<SkippedOperation>
     */
    private function emitClient(
        OpenApi $openApi,
        string $rootNamespace,
        string $rootDir,
        string $modelNamespace,
        NameRegistry $registry,
        NameRegistry $operationIdRegistry,
        NameNormaliser $normaliser,
        Bindings $bindings,
        EnumCatalog $enums,
        ComponentCatalog $components,
        InlinePayloadCatalog $inlinePayloads,
        array $preScannedSkips,
        Profile $profile,
        NameRegistry $tagRegistry,
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
        $emitter->emit($rootNamespace, $rootDir, $openApi, $bindings, $profile, $tagRegistry, $writes);

        return $emitter->drainSkipped();
    }

}
