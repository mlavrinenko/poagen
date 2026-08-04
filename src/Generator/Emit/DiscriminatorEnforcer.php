<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\Discriminator;
use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Poagen\Generator\Generator\Profile;
use Poagen\Generator\Generator\UnionGuidanceValidator;

use function count;
use function implode;
use function sprintf;

/**
 * Decides how every property-level ref-only `oneOf` / `anyOf` picks a branch,
 * in one pass over `components.schemas[*].properties[*]`.
 *
 * Four layers, tried in this order, and the order is the design
 * (`declare-an-undiscriminated-union-as-raw-data`):
 *
 *   1. a tag inside the value — the document's own `discriminator`, or a
 *      `Profile::$discriminators` entry naming the wire field;
 *   2. a tag on the enclosing object — `Profile::$unionTags`, or a
 *      `discriminator` the document put on the parent component. This is where
 *      GitHub actually keeps the tag for `event.payload` and
 *      `secret-scanning-location.details`;
 *   3. a discriminating field computed from the branches themselves
 *      ({@see BranchSelectors}), needing no guidance at all;
 *   4. a `Profile::$unionPins` entry narrowing the property to one branch.
 *
 * Anything left is refused, naming the branches that collide and every way to
 * resolve it. Refusals are collected rather than thrown, so one run reports
 * every problem in the document instead of the first
 * (abort-on-unrepresentable-constructs).
 *
 * Mutates two things in place, so everything downstream sees one uniform input:
 * a `Profile::$discriminators` entry becomes a synthetic `Discriminator` on the
 * property, and a pin rewrites the branch list to the single ref it names — the
 * existing resolver then types the property as that one class and attaches no
 * attribute at all, which is what "pinning types it as that single class" has
 * to mean.
 */
final readonly class DiscriminatorEnforcer
{
    /**
     * @param array<string,string> $overrides Profile::$discriminators — '<Component>.<property>' => wire field
     */
    public function __construct(
        private array $overrides = [],
        private ?Profile $profile = null,
    ) {}

    public function enforce(OpenApi $openApi): UnionCatalog
    {
        $byPointer = [];
        $byKey = [];
        $failures = [];

        foreach (self::unionProperties($openApi) as [$component, $property, $parent, $schema]) {
            $key = $component . '.' . $property;
            $resolution = $this->resolve($key, $parent, $schema, $openApi);

            if (!$resolution instanceof UnionResolution) {
                $failures[] = new SkippedComponent($component, $this->refusal($key, $schema, $openApi));

                continue;
            }

            $byPointer[SynthesisedModel::originOf($schema)] = $resolution;
            $byKey[$key] = $resolution;
        }

        return new UnionCatalog($byPointer, $byKey, $failures);
    }

    /**
     * Every ref-only union hanging off a named component's property, as
     * `[component, property, enclosing schema, property schema]`.
     *
     * @return list<array{0:string,1:string,2:Schema,3:Schema}>
     */
    public static function unionProperties(OpenApi $openApi): array
    {
        $components = $openApi->components;

        if ($components === null) {
            return [];
        }

        /** @var array<string,Schema|Reference> $schemas */
        $schemas = $components->schemas ?? [];
        $out = [];

        foreach ($schemas as $name => $schema) {
            if (!$schema instanceof Schema) {
                continue;
            }

            /** @var array<string,Schema|Reference> $properties */
            $properties = $schema->properties ?? [];

            foreach ($properties as $property => $propertySchema) {
                if ($propertySchema instanceof Schema && self::branchRefs($propertySchema) !== null) {
                    $out[] = [(string) $name, (string) $property, $schema, $propertySchema];
                }
            }
        }

        return $out;
    }

    /**
     * The branch list of a ref-only `oneOf`/`anyOf`, or null when the schema is
     * not that shape. `oneOf` wins when a document writes both.
     *
     * @return list<Reference>|null
     */
    public static function branchRefs(Schema $schema): ?array
    {
        $branches = SchemaWalk::oneOfOrAnyOf($schema);

        if ($branches === []) {
            return null;
        }

        $refs = [];

        foreach ($branches as $branch) {
            if (!$branch instanceof Reference) {
                return null;
            }

            $refs[] = $branch;
        }

        return $refs;
    }

    private function resolve(string $key, Schema $parent, Schema $schema, OpenApi $openApi): ?UnionResolution
    {
        $position = SynthesisedModel::originOf($schema);
        /** @var list<Reference> $refs */
        $refs = self::branchRefs($schema);

        $inValue = $this->tagInValue($schema, $key);

        if ($inValue !== null) {
            return UnionResolution::tagInValue($position, $inValue, count($refs));
        }

        $onParent = UnionTagBinding::resolve($key, $position, $parent, $refs, $this->profile, $openApi);

        if ($onParent instanceof UnionResolution) {
            return $onParent;
        }

        $selectors = BranchSelectors::compute($refs, $openApi);

        if ($selectors->decidable()) {
            return UnionResolution::structural($position, $selectors);
        }

        return $this->pin($key, $position, $schema, $refs);
    }

    /**
     * Layer one. The document's own `discriminator` wins; a
     * `Profile::$discriminators` entry is attached as a synthetic one so the
     * downstream emitter sees a single shape.
     */
    private function tagInValue(Schema $schema, string $key): ?string
    {
        $declared = $schema->discriminator;

        if ($declared instanceof Discriminator) {
            return $declared->propertyName;
        }

        $field = $this->overrides[$key] ?? null;

        if ($field === null) {
            return null;
        }

        $schema->discriminator = new Discriminator(['propertyName' => $field]);

        return $field;
    }

    /**
     * Layer four. Rewrites the branch list to the pinned ref so the property
     * types as that single class, and reports the narrowing on every run — a
     * pin is the only guidance key that discards declared shapes, and the
     * discarded branches accept each other's payloads.
     *
     * A pin naming a branch outside the union falls through to null on purpose.
     * {@see UnionGuidanceValidator} fails the run
     * naming the entry; refusing here would report the union as the cause when
     * the guidance is (`guidance-cannot-mislead`).
     *
     * @param list<Reference> $refs
     */
    private function pin(string $key, string $position, Schema $schema, array $refs): ?UnionResolution
    {
        $entry = $this->profile?->unionPins[$key] ?? null;

        if ($entry === null) {
            return null;
        }

        $branch = $entry['branch'] ?? '';
        $reason = $entry['reason'] ?? '';

        foreach ($refs as $ref) {
            if (ComponentName::rawFromRef($ref->getReference()) !== $branch) {
                continue;
            }

            $schema->oneOf = [$ref];
            $schema->anyOf = [];

            return UnionResolution::pin($position, $key, $branch, $reason, count($refs) - 1);
        }

        return null;
    }

    private function refusal(string $key, Schema $schema, OpenApi $openApi): string
    {
        /** @var list<Reference> $refs */
        $refs = self::branchRefs($schema);
        $undecidable = BranchSelectors::compute($refs, $openApi)->undecidable;

        return sprintf(
            'Undiscriminated union at %s (%s): branches %s share every discriminating field — each requires nothing '
                . 'the others do not also declare, so no payload could select between them and poagen will not '
                . "guess. Resolve it by adding a `discriminator` to the document, by a Profile::\$unionTags['%s'] "
                . "entry naming a tag property on the enclosing object, or by a Profile::\$unionPins['%s'] entry "
                . 'pinning one branch with a written reason.',
            SynthesisedModel::originOf($schema),
            $key,
            implode(', ', $undecidable),
            $key,
            $key,
        );
    }
}
