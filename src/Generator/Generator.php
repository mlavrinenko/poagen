<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator;

use cebe\openapi\json\JsonPointer;
use cebe\openapi\spec\OpenApi;
use Poagen\Generator\Exception\UnrepresentableConstructsException;
use Poagen\Generator\Generator\Emit\DanglingReferenceScanner;
use Poagen\Generator\Generator\Emit\OperationAnalyzer;
use Poagen\Generator\Generator\Emit\UnionCatalog;
use Poagen\Generator\SchemaReader;

use const DIRECTORY_SEPARATOR;

/**
 * Orchestrates a single generation run: schema + profile + bindings → files.
 */
final readonly class Generator
{
    private ModelPlanner $modelPlanner;

    public function __construct(
        private AttributeScanner $scanner,
        Emit\ModelEmitter $modelEmitter = new Emit\ModelEmitter(),
        private Emit\EnumEmitter $enumEmitter = new Emit\EnumEmitter(),
        private Emit\ApiExceptionEmitter $apiExceptionEmitter = new Emit\ApiExceptionEmitter(),
        private PlanApplier $applier = new PlanApplier(),
        private SkipListValidator $skipListValidator = new SkipListValidator(),
        private ProfileTargetValidator $profileTargets = new ProfileTargetValidator(),
        private PropertyRenameValidator $propertyRenameValidator = new PropertyRenameValidator(),
        private PhpDocTypeValidator $phpDocTypeValidator = new PhpDocTypeValidator(),
        private PropertyFormatValidator $propertyFormatValidator = new PropertyFormatValidator(),
        private FormatBindingValidator $formatBindingValidator = new FormatBindingValidator(),
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

        // Keep $ref nodes as Reference objects so the emitter can resolve them to typed cross-class references.
        // Reader choice (YAML vs JSON, by extension) is centralised in SchemaReader — see
        // generate-accepts-only-yaml-while-validate-accepts-json-too.
        $openApi = SchemaReader::read($profile->schema);
        // Populate JSON-pointer document positions, independent of reference resolution, so
        // diagnostics can point at the exact schema node responsible.
        $openApi->setDocumentContext($openApi, new JsonPointer(''));

        // A `security` requirement naming a scheme the document never
        // declared is a gap only the consumer can fill, so their declaration
        // is merged in before anything reads the document. The audit then
        // judges what is still undeclared, what poagen refuses to wire, and
        // what it can only report.
        $profileSecurityFailures = ProfileSecuritySchemes::apply($openApi, $profile->securitySchemes);
        $security = Emit\SecurityAudit::of($openApi);

        // declare-an-undiscriminated-union-as-raw-data: resolve every
        // property-level `oneOf`/`anyOf` through the four layers — a tag in the
        // value, a tag on the enclosing object, a discriminating field computed
        // from the branches, a profile pin — and collect what none of them
        // reaches instead of failing on the first
        // (abort-on-unrepresentable-constructs). Mutates the document, so it
        // runs before anything reads a property's branch list, and rides to the
        // emitters on $bindings.
        $unions = new Emit\DiscriminatorEnforcer($profile->discriminators, $profile)->enforce($openApi);
        $bindings = $bindings->withUnions($unions);

        // Same discipline, one walk further out: a `type` list naming several types PHP cannot
        // express as one (nullable-type-arrays), and a JSON Schema 2020-12 keyword no emitter
        // implements (swap-openapi-parser-for-31-support). One walk, two probes, one reason each.
        $schemaSkips = Emit\SchemaScan::run($openApi, [
            Emit\TypeListScanner::probe(...),
            Emit\UnsupportedKeywordScanner::probe(...),
        ]);

        $rootNamespace = rtrim($profile->namespace, '\\') . '\\Generated';
        $modelNamespace = $rootNamespace . '\\Model';
        $enumNamespace = $rootNamespace . '\\Enum';
        $rootDir = rtrim($profile->output, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'Generated';
        $modelDir = $rootDir . DIRECTORY_SEPARATOR . 'Model';
        $enumDir = $rootDir . DIRECTORY_SEPARATOR . 'Enum';

        $normaliser = Naming\NormaliserFactory::fromProfile($profile);
        $enums = new Enum\EnumCatalog($enumNamespace);
        $enumRegistry = new Naming\NameRegistry($normaliser);
        new Enum\ComponentEnumCollector()->collect($openApi, $enums, $enumRegistry);

        // Lazy-populated: every ref-resolution site routes through here
        // so each raw name is normalised exactly once and collisions are
        // caught the moment a second raw key tries to claim the same PHP
        // class.
        $registry = new Naming\NameRegistry($normaliser);
        // Sibling registry scoped to the ApiClient — operationIds form
        // their own collision space (PHP method names on one class)
        // separate from schema-component class names.
        $operationIdRegistry = new Naming\NameRegistry($normaliser);

        /** @var array<string,string> $writes */
        $writes = [];

        $components = Emit\ComponentCatalog::build($openApi, $registry, $enums);
        // Both refusal sources a skip entry must cover — see OperationAnalyzer::preScanSkips().
        $preScannedSkips = OperationAnalyzer::preScanSkips($openApi, $schemaSkips['operations']);

        // Refuse, not cascade (a-skipped-component-leaves-dangling-references-behind-it) — see DanglingReferenceScanner.
        $unrepresentable = [...$components->skipped(), ...$unions->failures(), ...$schemaSkips['components']];
        $dangling = DanglingReferenceScanner::scan($openApi, $unrepresentable, $preScannedSkips);
        $excludedComponents = $dangling['excluded'];
        $preScannedSkips += $dangling['operations']; // earlier reasons win

        // Payload classes are named before anything is emitted: the model planner emits them, and
        // the operation emitter points its parameters and return types at them (inline-body-and-response-schemas).
        $ledger = new Emit\ModelNameLedger();
        $inlinePayloads = Emit\InlinePayloadPlanner::build($openApi, $operationIdRegistry, $registry, Emit\InlineModelGroups::pins($profile->inlineModels), $ledger, $bindings, $profile->xmlElements, $preScannedSkips, $profile->unionPins);

        // See UnionCatalog::merge() for why the response-position half waits for this walk.
        $unions = UnionCatalog::merge($unions, $inlinePayloads->responseUnions());

        // An override the emitted model could not honour is refused here rather
        // than dropped — the type it has to agree with only exists once the
        // property is resolved, so the check rides back out of the emission
        // (Emit\PhpDocTypeCompatibility) instead of living in a validator.
        $modelFailures = $this->modelPlanner->plan(
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
            $profile->phpDocTypes,
        );
        $tagRegistry = new Naming\NameRegistry($normaliser);
        $skipped = $this->emitClient($openApi, $rootNamespace, $rootDir, $modelNamespace, $registry, $operationIdRegistry, $normaliser, $bindings, $enums, $components, $inlinePayloads, $preScannedSkips, $profile, $tagRegistry, $writes);
        $this->apiExceptionEmitter->emitInto($rootNamespace, $rootDir, $writes);
        $this->enumEmitter->emitAllInto($enums, $enumDir, $writes);

        $prunes = $this->prunePlanner->plan($rootDir, $writes);
        $notices = [
            ...Emit\OperationIdAdvisor::notices($openApi, $profile->methodRenames),
            ...Emit\FormatAdvisor::notices($openApi, $bindings),
            // Where a `mixed` survives, the vendor declared nothing there and
            // the run says so — `declared-shapes-become-types` tolerates that
            // one `mixed` only while it is visible.
            ...Emit\UnconstrainedFieldAdvisor::notices($openApi),
            ...Emit\SchemalessBodyAdvisor::notices($openApi),
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
            ...Emit\QuerySerializationAdvisor::notices($openApi),
            ...Emit\InlineModelMergeAdvisor::notices($openApi, $operationIdRegistry, $preScannedSkips),
        ];
        $skippedComponents = [...$components->skipped(), ...$unions->failures(), ...$schemaSkips['components'], ...$dangling['components']];

        $failures = [
            ...$profileSecurityFailures,
            ...$security->failures,
            ...Emit\UnsupportedKeywordScanner::webhookFailures($openApi, $profile->skip),
            ...Emit\ServerCatalog::variableProblems($openApi),
            ...$this->skipListValidator->validate($openApi, $components, $profile->skip, $skipped, $skippedComponents),
            ...$this->profileTargets->validate($openApi, $profile->inlineModels, $profile->methodRenames, $profile),
            ...$this->propertyRenameValidator->validate($openApi, $components, $profile->propertyRenames),
            ...$this->phpDocTypeValidator->validate($openApi, $components, $profile->phpDocTypes),
            // Reads $ledger only now: it is not fully populated until
            // $this->modelPlanner->plan() above has returned, since that is
            // what claims every synthesised model's name, not just the
            // named-component ones claimed before it runs.
            ...$this->propertyFormatValidator->validate($profile->propertyFormats, $ledger->claimedNames()),
            // Answerable from the class alone, so unlike its per-property
            // sibling above this one needs neither the document nor the ledger.
            ...$this->formatBindingValidator->validate($profile->formats),
            ...$modelFailures,
            ...$this->unionGuidance->validate($openApi, $profile, $unions, $operationIdRegistry),
        ];

        if ($failures !== []) {
            throw UnrepresentableConstructsException::forProblems($failures);
        }

        // Stamped once over the finished write set rather than inside each of
        // the emitters: every file poagen emits carries the header, and a
        // per-emitter copy would be a rule the next emitter could forget.
        // Stamping inside the plan rather than in {@see PlanApplier} is what
        // makes `--diff` and `--dry-run` show the same bytes a real run writes.
        $header = new Emit\GeneratedFileHeader($profile->source);
        $writes = array_map($header->stamp(...), $writes);

        return new GenerationPlan($writes, $prunes, $skipped, $skippedComponents, Emit\UnsupportedKeywordScanner::skippedWebhooks($openApi, $profile->skip), $notices);
    }

    /**
     * @param  array<string,string>                                $preScannedSkips raw operationId → reason
     * @param  array<string,string>                                $writes
     * @return list<Emit\SkippedOperation>
     */
    private function emitClient(
        OpenApi $openApi,
        string $rootNamespace,
        string $rootDir,
        string $modelNamespace,
        Naming\NameRegistry $registry,
        Naming\NameRegistry $operationIdRegistry,
        Naming\NameNormaliser $normaliser,
        Bindings $bindings,
        Enum\EnumCatalog $enums,
        Emit\ComponentCatalog $components,
        Emit\InlinePayloadCatalog $inlinePayloads,
        array $preScannedSkips,
        Profile $profile,
        Naming\NameRegistry $tagRegistry,
        array &$writes,
    ): array {
        if ($openApi->paths === null) {
            return [];
        }

        $emitter = new Emit\ClientEmitter(new Emit\OperationEmitter(
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
