<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Schema;

use function is_array;
use function is_string;
use function sprintf;

use const SORT_STRING;

/**
 * Names every position where the emitted type is `mixed` because the document
 * declared nothing there.
 *
 * `declared-shapes-become-types` allows exactly one `mixed`: the one a vendor
 * wrote themselves, by giving a node no type, no properties and no items. That
 * exception is only tolerable while it is *visible* — the goal's acid test asks
 * for the field to be reported, so a consumer can see where their vendor said
 * nothing instead of discovering it in production. Every other `mixed` the
 * generator could emit is now a resolved type, so what this reports is the
 * document's silence and never the generator's.
 *
 * Three spellings of that silence, each producing a different emitted type;
 * {@see self::REASONS} pairs each with the type a consumer will actually read.
 *
 * Reporting is all it does. Nothing is omitted from the emitted tree, so
 * nothing here moves the exit status — same distinction {@see FormatAdvisor}
 * draws, and for the same reason.
 *
 * @internal
 */
final readonly class UnconstrainedFieldAdvisor
{
    private const string SILENT = 'silent';
    private const string NO_ITEMS = 'no-items';
    private const string NO_VALUES = 'no-values';

    /** @var array<string,array{0:string,1:string}> reason key → [what the document left out, the type emitted] */
    private const array REASONS = [
        self::SILENT => ['declares no type, properties or items here', 'mixed'],
        self::NO_ITEMS => ['declares no `items` for this array', 'list<mixed>'],
        self::NO_VALUES => ['declares no properties and no schema for this object\'s values', 'array<string, mixed>'],
    ];

    /**
     * @return list<string> one line per position, ordered by document position
     *                      so the order is a fact about the document rather
     *                      than about iteration
     */
    public static function notices(OpenApi $openApi): array
    {
        /** @var array<string,string> $found document position → reason key */
        $found = [];

        foreach (SchemaWalk::roots($openApi) as $schema) {
            self::walk($schema, $found);
        }

        $positions = array_keys($found);
        sort($positions, SORT_STRING);

        $notices = [];

        foreach ($positions as $position) {
            [$missing, $emitted] = self::REASONS[$found[$position]];
            $notices[] = sprintf(
                'unconstrained value at %s — the document %s, so paogen emits `%s`. Declaring a shape there gives '
                    . 'the consumer a type; leaving it unconstrained is a choice this line makes visible.',
                $position,
                $missing,
                $emitted,
            );
        }

        return $notices;
    }

    /**
     * @param array<string,string> $found
     */
    private static function walk(Schema $schema, array &$found): void
    {
        $reason = self::reasonFor($schema);

        if (is_string($reason)) {
            $found[SynthesisedModel::originOf($schema)] = $reason;
        }

        foreach (SchemaWalk::children($schema) as $child) {
            self::walk($child, $found);
        }
    }

    /**
     * Which silence this node is, or null when the document said enough for
     * the generator to type it.
     */
    private static function reasonFor(Schema $schema): ?string
    {
        if (SchemaType::of($schema)->is('array')) {
            return $schema->items === null ? self::NO_ITEMS : null;
        }

        if (ObjectShape::is($schema)) {
            return ObjectShape::hasProperties($schema) || ObjectShape::hasValueSchema($schema)
                ? null
                : self::NO_VALUES;
        }

        return self::saysNothing($schema) ? self::SILENT : null;
    }

    /**
     * True when nothing on the node tells the generator what may arrive. A
     * `type`, a `format`, an `enum`, an `items` or a composition branch all
     * do, even where the rest is absent — each is read elsewhere, and each is
     * a fact the vendor stated.
     */
    private static function saysNothing(Schema $schema): bool
    {
        if (SchemaType::of($schema)->members !== []) {
            return false;
        }
        if (is_string($schema->format) && $schema->format !== '') {
            return false;
        }
        if (is_array($schema->enum) && $schema->enum !== []) {
            return false;
        }
        if ($schema->items !== null) {
            return false;
        }
        return SchemaWalk::compositionBranches($schema) === [];
    }
}
