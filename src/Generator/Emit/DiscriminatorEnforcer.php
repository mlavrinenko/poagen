<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Discriminator;
use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Exception\UndiscriminatedUnionException;

/**
 * Walks `components.schemas[*].properties[*]` and fails the run for any
 * property-level ref-only `oneOf` / `anyOf` that lacks a `discriminator`
 * and is not resolved by a `Profile::$discriminators` override (ADR-010,
 * T-030). Mutates in place: when an override supplies a wire field, a
 * synthetic `Discriminator` is attached to the property schema so the
 * downstream `ModelAttributeApplier` sees a uniform input.
 */
final readonly class DiscriminatorEnforcer
{
    /**
     * @param array<string,string> $overrides `<ComponentName>.<propertyName>' => wireField
     */
    public function __construct(private array $overrides = []) {}

    public function enforce(OpenApi $openApi): void
    {
        $components = $openApi->components;

        if ($components === null) {
            return;
        }

        /** @var array<string,Schema|Reference> $schemas */
        $schemas = $components->schemas ?? [];

        foreach ($schemas as $componentName => $componentSchema) {
            if (!$componentSchema instanceof Schema) {
                continue;
            }

            /** @var array<string,Schema|Reference> $properties */
            $properties = $componentSchema->properties ?? [];

            foreach ($properties as $propName => $propSchema) {
                $this->enforceProperty((string) $componentName, (string) $propName, $propSchema);
            }
        }
    }

    private function enforceProperty(string $componentName, string $propName, Schema|Reference $propSchema): void
    {
        if (!$propSchema instanceof Schema) {
            return;
        }

        if (!$this->isRefUnion($propSchema)) {
            return;
        }

        if ($propSchema->discriminator instanceof Discriminator) {
            return;
        }

        $key = $componentName . '.' . $propName;
        $wireField = $this->overrides[$key] ?? null;

        if ($wireField !== null) {
            $propSchema->discriminator = new Discriminator(['propertyName' => $wireField]);

            return;
        }

        throw UndiscriminatedUnionException::forProperty($componentName, $propName);
    }

    private function isRefUnion(Schema $schema): bool
    {
        /** @var array<Schema|Reference> $oneOf */
        $oneOf = $schema->oneOf ?? [];
        /** @var array<Schema|Reference> $anyOf */
        $anyOf = $schema->anyOf ?? [];

        $branches = $oneOf !== [] ? $oneOf : $anyOf;

        if ($branches === []) {
            return false;
        }

        foreach ($branches as $branch) {
            if (!$branch instanceof Reference) {
                return false;
            }
        }

        return true;
    }
}
