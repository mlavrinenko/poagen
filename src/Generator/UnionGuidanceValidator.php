<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Emit\ComponentName;
use Mlavrinenko\Paogen\Generator\Emit\DiscriminatorEnforcer;
use Mlavrinenko\Paogen\Generator\Emit\ResponseUnionGuidanceIndex;
use Mlavrinenko\Paogen\Generator\Emit\UnionCatalog;
use Mlavrinenko\Paogen\Generator\Emit\UnionResolution;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;

use function implode;
use function in_array;
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
    public function validate(OpenApi $openApi, Profile $profile, UnionCatalog $unions, NameRegistry $operationIdRegistry): array
    {
        $index = $this->index($openApi, $operationIdRegistry);

        return [
            ...$this->validateTags($profile, $index, $openApi),
            ...$this->validatePins($profile, $index, $unions),
        ];
    }

    /**
     * @param array<string,array{0:?Schema,1:Schema,2:list<string>}> $index
     *
     * @return list<string>
     */
    private function validateTags(Profile $profile, array $index, OpenApi $openApi): array
    {
        $failures = [];

        foreach ($profile->unionTags as $key => $entry) {
            $union = $index[$key] ?? null;

            if ($union === null) {
                $failures[] = UnionTagGuidanceChecks::absent('$unionTags', (string) $key);

                continue;
            }

            [$parent, , $branches] = $union;
            $field = $entry['field'] ?? '';
            /** @var array<string,string> $map */
            $map = $entry['map'] ?? [];

            $failures = [...$failures, ...UnionTagGuidanceChecks::field((string) $key, $field, $parent)];
            $failures = [...$failures, ...UnionTagGuidanceChecks::branches((string) $key, $map, $branches)];
            $failures = [...$failures, ...UnionTagGuidanceChecks::tagValues((string) $key, $field, $map, $parent, $openApi)];
        }

        return $failures;
    }

    /**
     * @param array<string,array{0:?Schema,1:Schema,2:list<string>}> $index
     *
     * @return list<string>
     */
    private function validatePins(Profile $profile, array $index, UnionCatalog $unions): array
    {
        $failures = [];

        foreach ($profile->unionPins as $key => $entry) {
            $union = $index[$key] ?? null;

            if ($union === null) {
                $failures[] = UnionTagGuidanceChecks::absent('$unionPins', (string) $key);

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
     * Every union the document carries, keyed the way the profile keys it —
     * `'<ComponentName>.<propertyName>'` for a property-level one, and
     * `'<rawOperationId>.response'` for a whole 2xx response
     * ({@see ResponseUnionGuidanceIndex}, `a-union-response-selects-its-branch`).
     * A response union carries no parent Schema — {@see UnionTagGuidanceChecks::field()}
     * is what turns that into a clear failure rather than a null-pointer.
     *
     * @return array<string,array{0:?Schema,1:Schema,2:list<string>}>
     */
    private function index(OpenApi $openApi, NameRegistry $operationIdRegistry): array
    {
        return [...$this->indexProperties($openApi), ...ResponseUnionGuidanceIndex::build($openApi, $operationIdRegistry)];
    }

    /**
     * @return array<string,array{0:Schema,1:Schema,2:list<string>}>
     */
    private function indexProperties(OpenApi $openApi): array
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
