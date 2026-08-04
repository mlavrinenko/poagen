<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use Nette\PhpGenerator\PhpNamespace;

/**
 * Shortens a composite PHPDoc type string (`list<\Foo\Bar>`,
 * `?array<string, \Foo\Bar>`, ...) to the form valid in one namespace,
 * registering a `use` for every class the string references along the way.
 *
 * nette resolves a *signature* type against a namespace automatically —
 * {@see PhpNamespace::simplifyType()} is the same machinery, but a doc
 * comment is an opaque string to nette's printer (T-260730), so an emitter
 * has to call it by hand before the type reaches {@see addComment()}.
 *
 * @internal
 */
final class DocTypeSimplifier
{
    public static function shorten(PhpNamespace $namespace, string $docType): string
    {
        preg_replace_callback(
            '~\\\\[\w\x7f-\xff]+(?:\\\\[\w\x7f-\xff]+)*~',
            static function (array $m) use ($namespace): string {
                $namespace->addUse(ltrim($m[0], '\\'));

                return $m[0];
            },
            $docType,
        );

        return $namespace->simplifyType($docType);
    }

    /**
     * True when `$docType` is itself a `|`-joined union — `string|array`,
     * not `list<string|int>`, where the `|` sits inside a generic's `<>`
     * and names the item type instead. `?T` only nullifies a single type;
     * a caller prefixing that onto a real union (`?string|array`) writes
     * something PHPStan does not read as "the whole union, nullable" —
     * only a bracket-depth-aware reading tells the two apart.
     */
    public static function isTopLevelUnion(string $docType): bool
    {
        $depth = 0;

        foreach (str_split($docType) as $char) {
            $depth += match ($char) {
                '<' => 1,
                '>' => -1,
                default => 0,
            };

            if ($char === '|' && $depth === 0) {
                return true;
            }
        }

        return false;
    }
}
