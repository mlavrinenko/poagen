<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use Nette\PhpGenerator\PhpNamespace;

use function sprintf;

/**
 * Whether two operations' response maps are one declaration, and — when they
 * are not — the first place they part company.
 *
 * Identity here is identity of the EMITTED declaration, not of the spec
 * objects behind it: two operations share a `StatusResponseMap` exactly when
 * the emitter would write the same literal for both. Comparing the rendered
 * expression rather than a hand-enumerated field list is what keeps that true
 * as {@see ReturnSpec} grows — a field the emitter never reads cannot make
 * two identical literals compare unequal, and a field it does read cannot
 * slip past a comparison nobody remembered to extend.
 *
 * Rendering happens into a throwaway {@see PhpNamespace} so the answer never
 * depends on which `use` statements the real client file happened to have
 * accumulated by the time an operation was reached.
 *
 * @internal
 */
final readonly class EnvelopeFingerprint
{
    private const string SCRATCH = 'Poagen\\Generator\\ResponseMapFingerprint';

    public static function of(EnvelopeSpec $envelope, string $modelNamespace): string
    {
        return new EnvelopeTypeEmitter()->expr(self::scratch(), $envelope, $modelNamespace);
    }

    /**
     * `null` when the two are one declaration; otherwise a phrase naming what
     * differs, in the shape {@see InlineModelMergeValidator}'s message
     * already uses ("... differ on ...").
     */
    public static function firstDifference(EnvelopeSpec $first, EnvelopeSpec $second, string $modelNamespace): ?string
    {
        if (self::of($first, $modelNamespace) === self::of($second, $modelNamespace)) {
            return null;
        }

        $left = self::statuses($first, $modelNamespace);
        $right = self::statuses($second, $modelNamespace);

        foreach ($left as [$status, $expr]) {
            $other = self::find($right, $status);

            if ($other === null) {
                return sprintf("status '%s', which the first declares and the second does not", $status);
            }

            if ($other !== $expr) {
                return sprintf(
                    "status '%s', which resolves to %s in the first and %s in the second",
                    $status,
                    $expr,
                    $other,
                );
            }
        }

        foreach ($right as [$status]) {
            if (self::find($left, $status) === null) {
                return sprintf("status '%s', which the second declares and the first does not", $status);
            }
        }

        // Same statuses, same bodies, different literal: the only thing left
        // is the order the document declared them in, which the emitted list
        // preserves.
        return 'the order their statuses are declared in';
    }

    /**
     * Status text paired with the expression its body emits — a list of pairs
     * rather than a map, for the reason {@see EnvelopeSpec} spells out:
     * `'200'` is exactly the numeric-looking string PHP folds to an int key.
     *
     * @return list<array{0: string, 1: string}>
     */
    private static function statuses(EnvelopeSpec $envelope, string $modelNamespace): array
    {
        $namespace = self::scratch();
        $types = new ResponseTypeEmitter();
        $out = [];

        foreach ($envelope->entries() as [$status, $spec]) {
            $out[] = [
                $status,
                $spec->kind === ReturnSpec::KIND_VOID ? 'null' : $types->expr($namespace, $spec, $modelNamespace),
            ];
        }

        return $out;
    }

    /**
     * @param list<array{0: string, 1: string}> $pairs
     */
    private static function find(array $pairs, string $status): ?string
    {
        foreach ($pairs as [$candidate, $expr]) {
            if ($candidate === $status) {
                return $expr;
            }
        }

        return null;
    }

    private static function scratch(): PhpNamespace
    {
        return new PhpNamespace(self::SCRATCH);
    }
}
