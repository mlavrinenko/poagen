<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\Schema;

use function array_keys;
use function count;
use function sprintf;

/**
 * A merge whose sites do not all emit the identical shape fails the run —
 * a consumer cannot merge two classes into one and silently lose a field
 * (name-inline-schemas-by-operation-and-status). Every site is compared
 * against the first rather than every pair against every other: agreeing
 * with the first is transitive across a group that all agrees, and the
 * first disagreement is exactly what the message needs to name.
 *
 * @internal
 */
final readonly class InlineModelMergeValidator
{
    /**
     * @param  array<string,Schema> $schemas site → the schema `InlineModelSiteResolver` resolved
     *                                        there, at least two entries
     * @return list<string>         zero or one failure line
     */
    public static function mismatches(string $className, array $schemas): array
    {
        $sites = array_keys($schemas);
        $first = $sites[0];
        $count = count($sites);

        for ($i = 1; $i < $count; ++$i) {
            $site = $sites[$i];
            $reason = InlineShapeFingerprint::firstDifference($schemas[$first], $schemas[$site]);

            if ($reason !== null) {
                return [sprintf(
                    "Profile::\$inlineModels['%s'] merges sites that do not emit the identical shape: '%s' and "
                        . "'%s' differ on %s. A consumer cannot merge two classes into one and silently lose a "
                        . 'field — resolve the difference in the document, or drop one site from the merge.',
                    $className,
                    $first,
                    $site,
                    $reason,
                )];
            }
        }

        return [];
    }
}
