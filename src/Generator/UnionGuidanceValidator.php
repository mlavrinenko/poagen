<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Emit\ComponentName;
use Mlavrinenko\Paogen\Generator\Emit\DiscriminatorEnforcer;
use Mlavrinenko\Paogen\Generator\Emit\EffectiveShape;
use Mlavrinenko\Paogen\Generator\Emit\UnionCatalog;
use Mlavrinenko\Paogen\Generator\Emit\UnionResolution;

use function implode;
use function in_array;
use function is_array;
use function is_string;
use function sprintf;

/**
 * Cross-checks `Profile::$unionTags` and `Profile::$unionPins` against the
 * document, so no entry can quietly be wrong (`guidance-cannot-mislead`).
 *
 * Both keys are claims, and every part of each claim is checkable: that the
 * component exists, that it declares that property, that the property is a
 * union at all, that the named tag field is a sibling on the enclosing object,
 * that each branch named is actually one of the union's branches, and — where
 * the tag field declares an `enum` — that each tag value is one the document
 * permits. An entry naming something absent fails the run rather than silently
 * not applying, which is the failure mode guidance is most prone to: it costs
 * nothing to write, looks like it works, and stops applying the moment a vendor
 * renames what it named.
 *
 * Staleness applies to pins and not to tags, and the asymmetry is the point. A
 * pin suppresses — it discards declared branches, and it is the only guidance
 * key whose absence changes the exit status — so it inherits `$skip`'s rule
 * that guidance outliving its cause is itself a failure. A tag refines: it
 * names a fact about the document that stays true whether or not paogen could
 * also have computed a branch selector, so there is nothing to expire. The
 * same line already separates `$skip` from `$methodRenames`, which is never
 * checked for having become derivable.
 *
 * Returns failure lines rather than throwing, so one run reports every problem
 * (abort-on-unrepresentable-constructs).
 */
final readonly class UnionGuidanceValidator
{
    /**
     * @return list<string> failure lines; empty means the run may proceed
     */
    public function validate(OpenApi $openApi, Profile $profile, UnionCatalog $unions): array
    {
        $index = $this->index($openApi);

        return [
            ...$this->validateTags($profile, $index, $openApi),
            ...$this->validatePins($profile, $index, $unions),
        ];
    }

    /**
     * @param array<string,array{0:Schema,1:Schema,2:list<string>}> $index
     *
     * @return list<string>
     */
    private function validateTags(Profile $profile, array $index, OpenApi $openApi): array
    {
        $failures = [];

        foreach ($profile->unionTags as $key => $entry) {
            $union = $index[$key] ?? null;

            if ($union === null) {
                $failures[] = $this->absent('$unionTags', (string) $key);

                continue;
            }

            [$parent, , $branches] = $union;
            $field = $entry['field'] ?? '';
            /** @var array<string,string> $map */
            $map = $entry['map'] ?? [];

            $failures = [...$failures, ...$this->checkField((string) $key, $field, $parent)];
            $failures = [...$failures, ...$this->checkBranches((string) $key, $map, $branches)];
            $failures = [...$failures, ...$this->checkTagValues((string) $key, $field, $map, $parent, $openApi)];
        }

        return $failures;
    }

    /**
     * @param array<string,array{0:Schema,1:Schema,2:list<string>}> $index
     *
     * @return list<string>
     */
    private function validatePins(Profile $profile, array $index, UnionCatalog $unions): array
    {
        $failures = [];

        foreach ($profile->unionPins as $key => $entry) {
            $union = $index[$key] ?? null;

            if ($union === null) {
                $failures[] = $this->absent('$unionPins', (string) $key);

                continue;
            }

            $branch = $entry['branch'] ?? '';
            $reason = $entry['reason'] ?? '';
            [, , $branches] = $union;

            if (!in_array($branch, $branches, true)) {
                $failures[] = sprintf(
                    "Profile::\$unionPins['%s'] pins the branch '%s', which is not one of that union's branches "
                        . '(%s) — a pin can only choose among the shapes the document declared.',
                    $key,
                    $branch,
                    implode(', ', $branches),
                );

                continue;
            }

            if (trim($reason) === '') {
                $failures[] = sprintf(
                    "Profile::\$unionPins['%s'] carries no reason. A pin discards declared branches, so it states "
                        . 'why in writing, the same as a $skip entry.',
                    $key,
                );
            }

            $kind = $unions->kindFor((string) $key);

            if ($kind !== null && $kind !== UnionResolution::KIND_PIN) {
                $failures[] = sprintf(
                    "Profile::\$unionPins['%s'] is stale — that union now selects a branch on its own (%s), so the "
                        . 'pin discards branches for no reason; delete this entry.',
                    $key,
                    $kind,
                );
            }
        }

        return $failures;
    }

    /**
     * @return list<string>
     */
    private function checkField(string $key, string $field, Schema $parent): array
    {
        /** @var array<string,Schema|Reference> $properties */
        $properties = $parent->properties ?? [];

        if ($field !== '' && isset($properties[$field])) {
            return [];
        }

        return [sprintf(
            "Profile::\$unionTags['%s'] names the tag field '%s', which the enclosing component does not declare. "
                . 'The tag has to be a sibling of the union — one of %s.',
            $key,
            $field,
            implode(', ', array_map(strval(...), array_keys($properties))),
        )];
    }

    /**
     * @param array<string,string> $map
     * @param list<string>         $branches
     *
     * @return list<string>
     */
    private function checkBranches(string $key, array $map, array $branches): array
    {
        $failures = [];

        if ($map === []) {
            return [sprintf(
                "Profile::\$unionTags['%s'] carries no value-to-branch map, so it names a tag field and no branches "
                    . 'for it to select.',
                $key,
            )];
        }

        foreach ($map as $tag => $branch) {
            if (!in_array($branch, $branches, true)) {
                $failures[] = sprintf(
                    "Profile::\$unionTags['%s'] maps '%s' to '%s', which is not one of that union's branches (%s).",
                    $key,
                    $tag,
                    $branch,
                    implode(', ', $branches),
                );
            }
        }

        return $failures;
    }

    /**
     * A tag value outside the field's own `enum` is a claim the document
     * contradicts. An enum value the map does not cover is not — the run
     * reports it as a notice, because permitting a shape nobody typed is the
     * vendor's choice rather than the consumer's mistake.
     *
     * @param array<string,string> $map
     *
     * @return list<string>
     */
    private function checkTagValues(string $key, string $field, array $map, Schema $parent, OpenApi $openApi): array
    {
        /** @var array<string,Schema|Reference> $properties */
        $properties = $parent->properties ?? [];
        $node = $properties[$field] ?? null;
        $schema = $node === null ? null : EffectiveShape::resolve($node, $openApi);

        if (!$schema instanceof Schema || !is_array($schema->enum) || $schema->enum === []) {
            return [];
        }

        $permitted = [];

        foreach ($schema->enum as $value) {
            if (is_string($value)) {
                $permitted[] = $value;
            }
        }

        $failures = [];

        foreach (array_keys($map) as $tag) {
            if (!in_array((string) $tag, $permitted, true)) {
                $failures[] = sprintf(
                    "Profile::\$unionTags['%s'] maps the value '%s', which '%s' does not enumerate (%s).",
                    $key,
                    $tag,
                    $field,
                    implode(', ', $permitted),
                );
            }
        }

        return $failures;
    }

    private function absent(string $property, string $key): string
    {
        return sprintf(
            "Profile::%s['%s'] names no property-level `oneOf`/`anyOf` in the document — the key is "
                . "'<ComponentName>.<propertyName>', and that component either does not exist, does not declare that "
                . 'property, or declares it as something other than a union of `$ref` branches.',
            $property,
            $key,
        );
    }

    /**
     * Every union the document carries, keyed the way the profile keys it.
     *
     * @return array<string,array{0:Schema,1:Schema,2:list<string>}>
     */
    private function index(OpenApi $openApi): array
    {
        $out = [];

        foreach (DiscriminatorEnforcer::unionProperties($openApi) as [$component, $property, $parent, $schema]) {
            $branches = [];

            foreach (DiscriminatorEnforcer::branchRefs($schema) ?? [] as $ref) {
                $branches[] = ComponentName::rawFromRef($ref->getReference());
            }

            $out[$component . '.' . $property] = [$parent, $schema, $branches];
        }

        return $out;
    }
}
