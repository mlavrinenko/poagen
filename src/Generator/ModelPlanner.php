<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Emit\CompositionResolver;
use Mlavrinenko\Paogen\Generator\Emit\ModelEmitter;
use Mlavrinenko\Paogen\Generator\Emit\SynthesisedModel;
use Mlavrinenko\Paogen\Generator\Enum\EnumCatalog;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;
use Mlavrinenko\Paogen\Generator\Naming\NormalisationContext;
use Mlavrinenko\Paogen\Generator\Naming\SymbolKind;

/**
 * Walks `components.schemas`, drives {@see ModelEmitter} for every
 * object-typed component, and drains synthesised inline-object
 * children (T-013) in a FIFO queue until no more remain. Extracted
 * from {@see Generator} to keep that file under linecop (ADR-004).
 */
final readonly class ModelPlanner
{
    public function __construct(
        private ModelEmitter $emitter,
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
    ): void {
        $components = $openApi->components;

        if ($components === null) {
            return;
        }

        /** @var array<string,Schema|Reference> $schemas */
        $schemas = $components->schemas ?? [];
        $names = array_keys($schemas);
        sort($names, \SORT_STRING);

        /** @var list<SynthesisedModel> $pending */
        $pending = [];
        $context = new NormalisationContext(SymbolKind::SchemaComponent);

        foreach ($names as $rawName) {
            $schema = $schemas[$rawName];

            if (!$schema instanceof Schema) {
                continue;
            }

            $effective = $this->materialiseAllOf($schema, $openApi);

            if ($effective->type !== 'object') {
                continue;
            }

            $className = $registry->resolve($rawName, $context);
            $emission = $this->emitter->emit($modelNamespace, $className, $effective, $bindings, $enums, $registry);

            $writes[$modelDir . \DIRECTORY_SEPARATOR . $className . '.php'] = $emission->source;

            foreach ($emission->children as $child) {
                $pending[] = $child;
            }
        }

        $this->drain($pending, $modelNamespace, $modelDir, $registry, $bindings, $enums, $writes);
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
                $emission = $this->emitter->emit($modelNamespace, $child->name, $child->schema, $bindings, $enums, $registry);
                $writes[$modelDir . \DIRECTORY_SEPARATOR . $child->name . '.php'] = $emission->source;

                foreach ($emission->children as $grand) {
                    $pending[] = $grand;
                }
            }
        }
    }
}
