<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\json\JsonPointer;
use cebe\openapi\spec\Discriminator;
use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Exception\UndiscriminatedUnionException;
use Mlavrinenko\Paogen\Generator\Generator;

/**
 * Walks `components.schemas[*].properties[*]` and collects every
 * property-level ref-only `oneOf` / `anyOf` that lacks a `discriminator`
 * and is not resolved by a `Profile::$discriminators` override
 * (`attribute-and-phpdoc-driven-serialization`, T-030). Mutates in place:
 * when an override supplies a wire field, a
 * synthetic `Discriminator` is attached to the property schema so the
 * downstream `ModelAttributeApplier` sees a uniform input.
 *
 * Collects rather than throws (abort-on-unrepresentable-constructs): the
 * caller — {@see Generator} — gathers every
 * problem in the document before deciding whether the run may proceed,
 * instead of stopping at the first one. Each finding is reported as a
 * {@see SkippedComponent} keyed by the *component* (not the property): a
 * `Profile::$skip` entry for the component omits the whole thing from the
 * output, the same granularity every other skip already uses.
 */
final readonly class DiscriminatorEnforcer
{
    /**
     * @param array<string,string> $overrides '<ComponentName>.<propertyName>' => wireField
     */
    public function __construct(private array $overrides = []) {}

    /**
     * @return list<SkippedComponent>
     */
    public function enforce(OpenApi $openApi): array
    {
        $components = $openApi->components;

        if ($components === null) {
            return [];
        }

        /** @var array<string,Schema|Reference> $schemas */
        $schemas = $components->schemas ?? [];

        /** @var list<SkippedComponent> $problems */
        $problems = [];

        foreach ($schemas as $componentName => $componentSchema) {
            if (!$componentSchema instanceof Schema) {
                continue;
            }

            /** @var array<string,Schema|Reference> $properties */
            $properties = $componentSchema->properties ?? [];

            foreach ($properties as $propName => $propSchema) {
                $message = $this->enforceProperty((string) $componentName, (string) $propName, $propSchema);

                if ($message !== null) {
                    $problems[] = new SkippedComponent((string) $componentName, $message);
                }
            }
        }

        return $problems;
    }

    private function enforceProperty(string $componentName, string $propName, Schema|Reference $propSchema): ?string
    {
        if (!$propSchema instanceof Schema) {
            return null;
        }

        if (!$this->isRefUnion($propSchema)) {
            return null;
        }

        if ($propSchema->discriminator instanceof Discriminator) {
            return null;
        }

        $key = $componentName . '.' . $propName;
        $wireField = $this->overrides[$key] ?? null;

        if ($wireField !== null) {
            $propSchema->discriminator = new Discriminator(['propertyName' => $wireField]);

            return null;
        }

        $pointer = $propSchema->getDocumentPosition();
        $message = UndiscriminatedUnionException::forProperty($componentName, $propName)->getMessage();

        return $pointer instanceof JsonPointer ? $message . ' (' . $pointer->getPointer() . ')' : $message;
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
