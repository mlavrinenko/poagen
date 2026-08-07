<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use LogicException;
use Poagen\Generator\Generator\Emit\ComponentCatalog;
use Poagen\Generator\Generator\Emit\DiscriminatorEnforcer;
use Poagen\Generator\Generator\Emit\InlinePayloadPlanner;

use function in_array;
use function is_string;

use const DIRECTORY_SEPARATOR;
use const SORT_STRING;

/**
 * Walks the {@see ComponentCatalog}, dispatches each entry to the
 * appropriate emitter (Model / scalar VO / array wrapper / union interface),
 * and drains synthesised inline-object children in a FIFO queue. T-026 added
 * the shape-dispatch; the queue is the older T-013 path.
 */
final readonly class ModelPlanner
{
    public function __construct(
        private Emit\ModelEmitter $emitter,
        private Emit\ScalarVoEmitter $scalarEmitter = new Emit\ScalarVoEmitter(),
        private Emit\ArrayWrapperEmitter $arrayEmitter = new Emit\ArrayWrapperEmitter(),
        private Emit\UnionInterfaceEmitter $unionEmitter = new Emit\UnionInterfaceEmitter(),
    ) {}

    /**
     * @param array<string,string>   $writes
     * @param array<string,true>     $excludedComponents Raw component names to omit entirely — e.g. ones flagged
     *                                                    by {@see DiscriminatorEnforcer}
     *                                                    and accepted via `Profile::$skip` (abort-on-unrepresentable-constructs).
     * @param list<Emit\SynthesisedModel> $extraRoots Classes named outside the component catalogue — the operation
     *                                                    payloads {@see InlinePayloadPlanner}
     *                                                    found. They join the same queue as inline children, so nesting
     *                                                    below them is reached by the machinery that was already there.
     * @param array<string,string>   $propertyRenames    Profile::$propertyRenames, unsliced
     * @param array<string,string>   $phpDocTypes        Profile::$phpDocTypes, unsliced
     */
    public function plan(
        OpenApi $openApi,
        string $modelNamespace,
        string $modelDir,
        Naming\NameRegistry $registry,
        Bindings $bindings,
        Enum\EnumCatalog $enums,
        array &$writes,
        ComponentCatalog $components,
        array $excludedComponents = [],
        array $extraRoots = [],
        ?Emit\ModelNameLedger $ledger = null,
        array $propertyRenames = [],
        array $phpDocTypes = [],
    ): void {
        $ledger ??= new Emit\ModelNameLedger();
        $rawNames = array_keys($components->all());
        sort($rawNames, SORT_STRING);

        /** @var list<Emit\SynthesisedModel> $pending */
        $pending = $extraRoots;

        foreach ($rawNames as $rawName) {
            if (isset($excludedComponents[$rawName])) {
                continue;
            }

            $shape = $components->shapeOf($rawName);

            if (!$shape instanceof Emit\ComponentShape) {
                continue;
            }

            // Enum components land in the enum namespace and unsupported ones
            // land nowhere, so neither competes for a model class name.
            if (!in_array($shape->kind, [Emit\ComponentShape::KIND_ENUM, Emit\ComponentShape::KIND_UNSUPPORTED], true)) {
                $ledger->claim($shape->phpName, 'components.schemas/' . $rawName);
            }

            $this->emitShape($rawName, $shape, $openApi, $modelNamespace, $modelDir, $registry, $bindings, $enums, $components, $writes, $pending, $propertyRenames, $phpDocTypes);
        }

        $this->drain($pending, $modelNamespace, $modelDir, $registry, $bindings, $enums, $writes, $ledger);
    }

    /**
     * @param array<string,string>   $writes
     * @param list<Emit\SynthesisedModel> $pending
     * @param array<string,string>   $propertyRenames Profile::$propertyRenames, unsliced
     * @param array<string,string>   $phpDocTypes     Profile::$phpDocTypes, unsliced
     */
    private function emitShape(
        string $rawName,
        Emit\ComponentShape $shape,
        OpenApi $openApi,
        string $modelNamespace,
        string $modelDir,
        Naming\NameRegistry $registry,
        Bindings $bindings,
        Enum\EnumCatalog $enums,
        ComponentCatalog $components,
        array &$writes,
        array &$pending,
        array $propertyRenames = [],
        array $phpDocTypes = [],
    ): void {
        $path = $modelDir . DIRECTORY_SEPARATOR . $shape->phpName . '.php';

        switch ($shape->kind) {
            case Emit\ComponentShape::KIND_ENUM:
            case Emit\ComponentShape::KIND_UNSUPPORTED:
                return;

            case Emit\ComponentShape::KIND_OBJECT:
                $effective = $shape->schema ?? throw new LogicException('object shape missing schema');
                $this->emitObject($effective, $shape, $modelNamespace, $registry, $bindings, $enums, $components, $rawName, $path, $writes, $pending, $propertyRenames, $phpDocTypes);

                return;

            case Emit\ComponentShape::KIND_ALLOF_OBJECT:
                $effective = Emit\CompositionResolver::materialiseAllOf($shape->schema ?? throw new LogicException('allOf shape missing schema'), $openApi);

                if (!$effective instanceof Schema) {
                    return;
                }

                $this->emitObject($effective, $shape, $modelNamespace, $registry, $bindings, $enums, $components, $rawName, $path, $writes, $pending, $propertyRenames, $phpDocTypes);

                return;

            case Emit\ComponentShape::KIND_SCALAR:
                $writes[$path] = $this->scalarEmitter->emit($modelNamespace, $shape);

                return;

            case Emit\ComponentShape::KIND_ARRAY:
                $writes[$path] = $this->arrayEmitter->emit($modelNamespace, $shape, $bindings, $registry, $enums);

                return;

            case Emit\ComponentShape::KIND_UNION:
                $writes[$path] = $this->unionEmitter->emit($modelNamespace, $shape);
                $this->queueInlineUnionBranches($shape, $pending);

                return;
        }
    }

    /**
     * @param array<string,string>   $writes
     * @param list<Emit\SynthesisedModel> $pending
     * @param array<string,string>   $propertyRenames Profile::$propertyRenames, unsliced
     * @param array<string,string>   $phpDocTypes     Profile::$phpDocTypes, unsliced
     */
    private function emitObject(
        Schema $effective,
        Emit\ComponentShape $shape,
        string $modelNamespace,
        Naming\NameRegistry $registry,
        Bindings $bindings,
        Enum\EnumCatalog $enums,
        ComponentCatalog $components,
        string $rawName,
        string $path,
        array &$writes,
        array &$pending,
        array $propertyRenames = [],
        array $phpDocTypes = [],
    ): void {
        $emission = $this->emitter->emit(
            $modelNamespace,
            $shape->phpName,
            $effective,
            $bindings,
            $enums,
            $registry,
            $components->interfacesFor($rawName),
            $propertyRenames,
            $rawName,
            $phpDocTypes,
        );

        $writes[$path] = $emission->source;

        foreach ($emission->children as $child) {
            $pending[] = $child;
        }
    }

    /**
     * Convert inline-object branches of a top-level `oneOf` / `anyOf` into
     * synthesised branch classes (e.g. `FloatingIpCreateAssignToDroplet`)
     * that `implements <Interface>`. Reference branches are handled via
     * {@see ComponentCatalog::interfacesFor} when the target object Model
     * is emitted.
     *
     * @param list<Emit\SynthesisedModel> $pending
     */
    private function queueInlineUnionBranches(Emit\ComponentShape $shape, array &$pending): void
    {
        $parent = $shape->phpName;
        $index = 0;

        foreach ($shape->unionBranches as $branch) {
            ++$index;

            if (!$branch instanceof Schema) {
                continue;
            }

            $childName = $parent . $this->branchLabel($branch, $index);
            $pending[] = Emit\SynthesisedModel::forNode($childName, $branch, [$parent]);
        }
    }

    private function branchLabel(Schema $branch, int $index): string
    {
        $title = $branch->title;

        if (is_string($title) && $title !== '') {
            $pascal = Enum\EnumCatalog::pascalize($title);

            if ($pascal !== '') {
                return $pascal;
            }
        }

        return 'Branch' . $index;
    }

    /**
     * Drain the FIFO queue of synthesised inline-object classes (T-013).
     * Each emission may itself queue grandchildren; keep going until the
     * queue is empty. Sorting by name at each batch keeps byte-stability
     * across runs regardless of the order children were discovered.
     *
     * @param list<Emit\SynthesisedModel> $pending
     * @param array<string,string>   $writes
     */
    private function drain(
        array $pending,
        string $modelNamespace,
        string $modelDir,
        Naming\NameRegistry $registry,
        Bindings $bindings,
        Enum\EnumCatalog $enums,
        array &$writes,
        Emit\ModelNameLedger $ledger,
    ): void {
        while ($pending !== []) {
            usort(
                $pending,
                static fn(Emit\SynthesisedModel $a, Emit\SynthesisedModel $b): int => strcmp($a->name, $b->name),
            );

            $batch = $pending;
            $pending = [];

            foreach ($batch as $child) {
                $ledger->claim($child->name, $child->origin);
                $emission = $this->emitter->emit(
                    $modelNamespace,
                    $child->name,
                    $child->schema,
                    $bindings,
                    $enums,
                    $registry,
                    $child->implements,
                );
                $writes[$modelDir . DIRECTORY_SEPARATOR . $child->name . '.php'] = $emission->source;

                foreach ($emission->children as $grand) {
                    $pending[] = $grand;
                }
            }
        }
    }
}
