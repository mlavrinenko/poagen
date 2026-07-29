<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\json\JsonPointer;
use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Enum\EnumCatalog;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;
use Mlavrinenko\Paogen\Generator\Naming\NormalisationContext;
use Mlavrinenko\Paogen\Generator\Naming\SymbolKind;

/**
 * Classifies every named `components.schemas` entry into a {@see ComponentShape}
 * and carries the interface-membership graph implied by top-level `oneOf` /
 * `anyOf` components (T-026).
 *
 * Built once at the start of a generation run, consumed by {@see
 * \Mlavrinenko\Paogen\Generator\ModelPlanner} to pick the right emitter per
 * component and to tag object Models with the interfaces they implement.
 */
final class ComponentCatalog
{
    /** @var array<string, ComponentShape> keyed by raw component name */
    private array $shapes = [];

    /** @var array<string, list<string>> raw name → list of interface PHP names it must `implements` */
    private array $interfacesFor = [];

    /** @var list<SkippedComponent> */
    private array $skipped = [];

    public static function build(OpenApi $openApi, NameRegistry $registry, EnumCatalog $enums): self
    {
        $self = new self();
        $components = $openApi->components;

        if ($components === null) {
            return $self;
        }

        /** @var array<string, Schema|Reference> $schemas */
        $schemas = $components->schemas ?? [];
        $context = new NormalisationContext(SymbolKind::SchemaComponent);

        foreach ($schemas as $rawName => $schema) {
            if (!$schema instanceof Schema) {
                continue;
            }

            $phpName = $registry->resolve($rawName, $context);
            $shape = self::classify($rawName, $phpName, $schema, $enums);
            $self->shapes[$rawName] = $shape;

            if ($shape->kind === ComponentShape::KIND_UNSUPPORTED) {
                $self->skipped[] = new SkippedComponent($rawName, $shape->reason);
                continue;
            }

            if ($shape->kind !== ComponentShape::KIND_UNION) {
                continue;
            }

            foreach ($shape->unionBranches as $branch) {
                if (!$branch instanceof Reference) {
                    continue;
                }

                $targetRaw = ComponentName::rawFromRef($branch->getReference());

                if ($targetRaw === '') {
                    continue;
                }

                $self->interfacesFor[$targetRaw] ??= [];
                $self->interfacesFor[$targetRaw][] = $phpName;
            }
        }

        return $self;
    }

    private static function classify(string $rawName, string $phpName, Schema $schema, EnumCatalog $enums): ComponentShape
    {
        if ($enums->isEnumComponent($rawName)) {
            return new ComponentShape(ComponentShape::KIND_ENUM, $phpName, schema: $schema);
        }

        if (\is_array($schema->allOf) && $schema->allOf !== []) {
            return new ComponentShape(ComponentShape::KIND_ALLOF_OBJECT, $phpName, schema: $schema);
        }

        $oneOf = \is_array($schema->oneOf) ? $schema->oneOf : [];
        $anyOf = \is_array($schema->anyOf) ? $schema->anyOf : [];
        $branches = $oneOf !== [] ? $oneOf : $anyOf;

        if ($branches !== []) {
            return new ComponentShape(
                ComponentShape::KIND_UNION,
                $phpName,
                unionBranches: array_values($branches),
                schema: $schema,
            );
        }

        $type = $schema->type;

        if ($type === 'object' || (\is_array($schema->properties) && $schema->properties !== [])) {
            return new ComponentShape(ComponentShape::KIND_OBJECT, $phpName, schema: $schema);
        }

        if ($type === 'array') {
            $items = $schema->items;

            return new ComponentShape(
                ComponentShape::KIND_ARRAY,
                $phpName,
                arrayItems: $items instanceof Schema ? $items : null,
                schema: $schema,
            );
        }

        if (\in_array($type, ['string', 'integer', 'number', 'boolean'], true)) {
            return new ComponentShape(
                ComponentShape::KIND_SCALAR,
                $phpName,
                scalarType: $type,
                schema: $schema,
            );
        }

        return new ComponentShape(
            ComponentShape::KIND_UNSUPPORTED,
            $phpName,
            schema: $schema,
            reason: self::unsupportedReason($rawName, $schema),
        );
    }

    private static function unsupportedReason(string $rawName, Schema $schema): string
    {
        $type = \is_string($schema->type) ? $schema->type : 'unspecified';
        $pointer = $schema->getDocumentPosition();
        $location = $pointer instanceof JsonPointer ? " (schema at {$pointer->getPointer()})" : '';

        return \sprintf(
            'component `%s`%s has an unrecognised schema shape (type: %s, no oneOf/anyOf/allOf, no object '
                . 'properties) — paogen supports object, array, scalar (string/integer/number/boolean), '
                . 'allOf/oneOf/anyOf union, and enum component shapes; restructure the schema to match one of these',
            $rawName,
            $location,
            $type,
        );
    }

    public function shapeOf(string $rawName): ?ComponentShape
    {
        return $this->shapes[$rawName] ?? null;
    }

    /**
     * @return array<string, ComponentShape>
     */
    public function all(): array
    {
        return $this->shapes;
    }

    /**
     * @return list<string> interface PHP names the Model for $rawName must `implements`
     */
    public function interfacesFor(string $rawName): array
    {
        return $this->interfacesFor[$rawName] ?? [];
    }

    /**
     * @return list<SkippedComponent>
     */
    public function skipped(): array
    {
        return $this->skipped;
    }
}
