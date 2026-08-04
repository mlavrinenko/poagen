<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\Schema;

/**
 * A bare scalar plus an array of one — GitHub's `fields`/`has`. Neither
 * {@see CompositionResolver::resolveUnion()} (ref-only branches) nor
 * {@see CompositionResolver::resolveScalarUnion()} (every branch a bare
 * scalar) covers it: the latter returns null the moment a branch is an
 * array. Extracted from {@see CompositionResolver} to keep that file under
 * `quality-gates-at-maximum-strictness`'s 250-line limit, the same reason
 * `AllOfMerger` sits beside it rather than inside it — reached only through
 * {@see CompositionResolver::resolveScalarOrList()}, which finds the two
 * branches and is the one place `TypeResolver` and `ParameterShape` ask
 * this question.
 *
 * Ruling (`support-the-parameter-shapes-real-documents-use`): both branches
 * survive rather than one normalised away. Native `array` cannot be
 * parameterised, so `string|array` is as far as native PHP goes; the
 * PHPDoc carries what that loses, `string|list<string>`.
 *
 * @internal
 */
final readonly class ScalarOrListResolver
{
    /**
     * Null unless one branch is a bare scalar and the other a bare array of
     * a bare scalar.
     */
    public static function resolve(Schema $a, Schema $b, bool $nullable): ?TypeResolver
    {
        [$scalar, $list] = SchemaType::of($a)->is('array') ? [$b, $a] : [$a, $b];

        $scalarPhp = SchemaType::of($scalar)->scalarPhpType();
        $itemPhp = SchemaType::of($list)->is('array') && $list->items instanceof Schema
            ? SchemaType::of($list->items)->scalarPhpType()
            : null;

        if ($scalarPhp === null || $itemPhp === null) {
            return null;
        }

        $suffix = $nullable ? '|null' : '';

        return new TypeResolver(
            $scalarPhp . '|array' . $suffix,
            $scalarPhp . '|list<' . $itemPhp . '>' . $suffix,
            null,
            false,
        );
    }
}
