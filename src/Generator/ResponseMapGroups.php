<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator;

use Poagen\Generator\Exception\UnrepresentableConstructsException;

use function count;
use function preg_match;
use function sprintf;
use function strtolower;

/**
 * `Profile::$responseMaps` read as groups, plus the half of its validation
 * that needs nothing but the profile.
 *
 * The field names the operations whose response map is ONE shared
 * declaration, and the emitter then writes that declaration once. Nothing is
 * ever inferred: two operations that happen to declare identical responses
 * are emitted separately unless a group here says otherwise. That is the
 * 2026-08-02 ruling on inline models applied one layer up — structural
 * identity is not identity of meaning, so a group is a claim about meaning
 * and only a consumer can make it.
 *
 * Everything checked here is answerable from the profile alone: a key that is
 * not a PHP method name, a group of one, an operation named twice. So it is
 * checked before the document is read, rather than joining the collected pass
 * at the end of {@see Generator::plan()} the way most guidance validators do.
 * That is a deliberate and narrow departure from
 * `abort-on-unrepresentable-constructs`'s report-everything default: a group
 * that does not parse cannot be judged against a document at all, so every
 * downstream finding about it would be a restatement of the same typo rather
 * than an independent problem worth reporting alongside it.
 *
 * The document-dependent half — an operation the document does not carry, and
 * a group whose maps are not in fact identical — cannot be answered without
 * the document and does join the collected pass, in
 * {@see Emit\SharedResponseMapPlan}. {@see FormatBindingValidator} draws the
 * same line for `$formats` for the same reason.
 */
final readonly class ResponseMapGroups
{
    /** The shape {@see ProfileTargetValidator} already holds `$inlineModels` keys to. */
    private const string IDENTIFIER = '/^[A-Za-z_]\w*$/';

    /**
     * @param array<string, list<string>> $responseMaps Profile::$responseMaps
     *
     * @throws UnrepresentableConstructsException
     */
    public static function assertWellFormed(array $responseMaps): void
    {
        $failures = self::structuralFailures($responseMaps);

        if ($failures !== []) {
            throw UnrepresentableConstructsException::forProblems($failures);
        }
    }

    /**
     * @param  array<string, list<string>> $responseMaps Profile::$responseMaps
     * @return list<string>                failure lines; empty means every group parses
     */
    public static function structuralFailures(array $responseMaps): array
    {
        $failures = [];
        $names = [];
        $claimedBy = [];

        foreach ($responseMaps as $name => $operationIds) {
            if (preg_match(self::IDENTIFIER, $name) !== 1) {
                $failures[] = sprintf(
                    "Profile::\$responseMaps['%s'] is not a valid PHP method name — the key names the shared "
                        . 'declaration poagen emits, so it has to be callable.',
                    $name,
                );

                continue;
            }

            $folded = strtolower($name);

            if (isset($names[$folded])) {
                $failures[] = sprintf(
                    "Profile::\$responseMaps['%s'] collides with '%s' — PHP method names are case-insensitive, so "
                        . 'two declarations cannot differ only in case.',
                    $name,
                    $names[$folded],
                );

                continue;
            }

            $names[$folded] = $name;
            $failures = [...$failures, ...self::members($name, $operationIds, $claimedBy)];
        }

        return $failures;
    }

    /**
     * @param  list<string>         $operationIds
     * @param  array<string,string> $claimedBy operation id → the declaration that already named it
     * @return list<string>
     */
    private static function members(string $name, array $operationIds, array &$claimedBy): array
    {
        if (count($operationIds) < 2) {
            return [sprintf(
                "Profile::\$responseMaps['%s'] names fewer than two operations — a shared declaration needs at "
                    . 'least two call sites to share it, so a group of one moves the map out of line without '
                    . 'collapsing anything.',
                $name,
            )];
        }

        $failures = [];

        foreach ($operationIds as $operationId) {
            $owner = $claimedBy[$operationId] ?? null;

            if ($owner === $name) {
                $failures[] = sprintf(
                    "Profile::\$responseMaps['%s'] names the operation id '%s' twice.",
                    $name,
                    $operationId,
                );

                continue;
            }

            if ($owner !== null) {
                $failures[] = sprintf(
                    "Profile::\$responseMaps['%s'] names the operation id '%s', which '%s' already claims — an "
                        . 'operation declares one response map, so it belongs to one declaration.',
                    $name,
                    $operationId,
                    $owner,
                );

                continue;
            }

            $claimedBy[$operationId] = $name;
        }

        return $failures;
    }
}
