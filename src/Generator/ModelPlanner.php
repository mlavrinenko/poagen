<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Emit\ArrayWrapperEmitter;
use Mlavrinenko\Paogen\Generator\Emit\ComponentCatalog;
use Mlavrinenko\Paogen\Generator\Emit\ComponentShape;
use Mlavrinenko\Paogen\Generator\Emit\CompositionResolver;
use Mlavrinenko\Paogen\Generator\Emit\ModelEmitter;
use Mlavrinenko\Paogen\Generator\Emit\ScalarVoEmitter;
use Mlavrinenko\Paogen\Generator\Emit\SynthesisedModel;
use Mlavrinenko\Paogen\Generator\Emit\UnionInterfaceEmitter;
use Mlavrinenko\Paogen\Generator\Enum\EnumCatalog;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;

/**
 * Walks the {@see ComponentCatalog}, dispatches each entry to the
 * appropriate emitter (Model / scalar VO / array wrapper / union interface),
 * and drains synthesised inline-object children in a FIFO queue. T-026 added
 * the shape-dispatch; the queue is the older T-013 path.
 */
final readonly class ModelPlanner
{
    public function __construct(
        private ModelEmitter $emitter,
        private ScalarVoEmitter $scalarEmitter = new ScalarVoEmitter(),
        private ArrayWrapperEmitter $arrayEmitter = new ArrayWrapperEmitter(),
        private UnionInterfaceEmitter $unionEmitter = new UnionInterfaceEmitter(),
    ) {}

    /**
     * @param array<string,string> $writes
     */
    public function plan(
        OpenApi $openApi,
        string $modelNamespace,
        string $modelDir,
        NameRegistry $registry,
        Bindings $bindings,
        EnumCatalog $enums,
        array &$writes,
        ComponentCatalog $components,
    ): void {
        $rawNames = array_keys($components->all());
        sort($rawNames, \SORT_STRING);

        /** @var list<SynthesisedModel> $pending */
        $pending = [];

        foreach ($rawNames as $rawName) {
            $shape = $components->shapeOf($rawName);

            if (!$shape instanceof \Mlavrinenko\Paogen\Generator\Emit\ComponentShape) {
                continue;
            }

            $this->emitShape($rawName, $shape, $openApi, $modelNamespace, $modelDir, $registry, $bindings, $enums, $components, $writes, $pending);
        }

        $this->drain($pending, $modelNamespace, $modelDir, $registry, $bindings, $enums, $writes);
    }

    /**
     * @param array<string,string>   $writes
     * @param list<SynthesisedModel> $pending
     */
    private function emitShape(
        string $rawName,
        ComponentShape $shape,
        OpenApi $openApi,
        string $modelNamespace,
        string $modelDir,
        NameRegistry $registry,
        Bindings $bindings,
        EnumCatalog $enums,
        ComponentCatalog $components,
        array &$writes,
        array &$pending,
    ): void {
        $path = $modelDir . \DIRECTORY_SEPARATOR . $shape->phpName . '.php';

        switch ($shape->kind) {
            case ComponentShape::KIND_ENUM:
            case ComponentShape::KIND_UNSUPPORTED:
                return;

            case ComponentShape::KIND_OBJECT:
                $effective = $shape->schema ?? throw new \LogicException('object shape missing schema');
                $this->emitObject($effective, $shape, $modelNamespace, $registry, $bindings, $enums, $components, $rawName, $path, $writes, $pending);

                return;

            case ComponentShape::KIND_ALLOF_OBJECT:
                $effective = $this->materialiseAllOf($shape->schema ?? throw new \LogicException('allOf shape missing schema'), $openApi);

                if (!$effective instanceof \cebe\openapi\spec\Schema) {
                    return;
                }

                $this->emitObject($effective, $shape, $modelNamespace, $registry, $bindings, $enums, $components, $rawName, $path, $writes, $pending);

                return;

            case ComponentShape::KIND_SCALAR:
                $writes[$path] = $this->scalarEmitter->emit($modelNamespace, $shape);

                return;

            case ComponentShape::KIND_ARRAY:
                $writes[$path] = $this->arrayEmitter->emit($modelNamespace, $shape, $bindings, $registry, $enums);

                return;

            case ComponentShape::KIND_UNION:
                $writes[$path] = $this->unionEmitter->emit($modelNamespace, $shape);
                $this->queueInlineUnionBranches($shape, $pending);

                return;
        }
    }

    /**
     * @param array<string,string>   $writes
     * @param list<SynthesisedModel> $pending
     */
    private function emitObject(
        Schema $effective,
        ComponentShape $shape,
        string $modelNamespace,
        NameRegistry $registry,
        Bindings $bindings,
        EnumCatalog $enums,
        ComponentCatalog $components,
        string $rawName,
        string $path,
        array &$writes,
        array &$pending,
    ): void {
        $emission = $this->emitter->emit(
            $modelNamespace,
            $shape->phpName,
            $effective,
            $bindings,
            $enums,
            $registry,
            $components->interfacesFor($rawName),
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
     * @param list<SynthesisedModel> $pending
     */
    private function queueInlineUnionBranches(ComponentShape $shape, array &$pending): void
    {
        $parent = $shape->phpName;
        $index = 0;

        foreach ($shape->unionBranches as $branch) {
            ++$index;

            if (!$branch instanceof Schema) {
                continue;
            }

            $childName = $parent . $this->branchLabel($branch, $index);
            $pending[] = new SynthesisedModel($childName, $branch, [$parent]);
        }
    }

    private function branchLabel(Schema $branch, int $index): string
    {
        $title = $branch->title;

        if (\is_string($title) && $title !== '') {
            $pascal = EnumCatalog::pascalize($title);

            if ($pascal !== '') {
                return $pascal;
            }
        }

        return 'Branch' . $index;
    }

    /**
     * Flatten a top-level `allOf` schema into a single object-type Schema
     * whose `properties`/`required` are the union of its branches (T-008).
     * Returns null when no object branches were mergeable — caller drops it.
     */
    private function materialiseAllOf(Schema $schema, OpenApi $openApi): ?Schema
    {
        if (!\is_array($schema->allOf) || $schema->allOf === []) {
            return $schema;
        }

        return CompositionResolver::flattenAllOf($schema, $openApi);
    }

    /**
     * Drain the FIFO queue of synthesised inline-object classes (T-013).
     * Each emission may itself queue grandchildren; keep going until the
     * queue is empty. Sorting by name at each batch keeps byte-stability
     * across runs regardless of the order children were discovered.
     *
     * @param list<SynthesisedModel> $pending
     * @param array<string,string>   $writes
     */
    private function drain(
        array $pending,
        string $modelNamespace,
        string $modelDir,
        NameRegistry $registry,
        Bindings $bindings,
        EnumCatalog $enums,
        array &$writes,
    ): void {
        while ($pending !== []) {
            usort(
                $pending,
                static fn(SynthesisedModel $a, SynthesisedModel $b): int => strcmp($a->name, $b->name),
            );

            $batch = $pending;
            $pending = [];

            foreach ($batch as $child) {
                $emission = $this->emitter->emit(
                    $modelNamespace,
                    $child->name,
                    $child->schema,
                    $bindings,
                    $enums,
                    $registry,
                    $child->implements,
                );
                $writes[$modelDir . \DIRECTORY_SEPARATOR . $child->name . '.php'] = $emission->source;

                foreach ($emission->children as $grand) {
                    $pending[] = $grand;
                }
            }
        }
    }
}
