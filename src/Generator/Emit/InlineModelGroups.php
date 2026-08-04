<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use function is_string;

/**
 * Reads `Profile::$inlineModels` the way it is written — one class name to
 * many sites — and the two shapes everything downstream actually needs:
 * a normalised `class => list<site>` map, and the `site => class` pins
 * {@see InlinePayloadPlanner::build()} was always keyed by, inverted from it.
 *
 * A single site is a bare string (`'addclient.request' => 'AddClientRequest'`
 * spelled the consumer's way is `'AddClientRequest' => 'addclient.request'`);
 * several are a `list<string>`. Both are normalised to a `list<string>` here
 * so every caller past this one handles one shape.
 *
 * @internal
 */
final readonly class InlineModelGroups
{
    /**
     * @param  array<string, string|list<string>> $inlineModels Profile::$inlineModels
     * @return array<string, list<string>>         class name => site keys, in declaration order
     */
    public static function normalise(array $inlineModels): array
    {
        $out = [];

        foreach ($inlineModels as $className => $sites) {
            $out[$className] = is_string($sites) ? [$sites] : array_values($sites);
        }

        return $out;
    }

    /**
     * @param  array<string, string|list<string>> $inlineModels Profile::$inlineModels
     * @return array<string,string>                site key → class name, ready for
     *                                              {@see InlinePayloadPlanner::build()}'s `$pins`
     */
    public static function pins(array $inlineModels): array
    {
        $pins = [];

        foreach (self::normalise($inlineModels) as $className => $sites) {
            foreach ($sites as $site) {
                $pins[$site] = $className;
            }
        }

        return $pins;
    }
}
