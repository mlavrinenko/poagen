<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use Nette\PhpGenerator\PhpNamespace;
use ReflectionClassConstant;

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
 * `simplifyType()` treats any bareword it does not recognise as a PHP
 * builtin as an unqualified class name and makes it absolute, which is
 * correct for a real FQN missing its leading backslash but wrong for a
 * PHPStan pseudo-type (`non-empty-string`, `positive-int`, ...) sitting
 * inside a structural type — a pseudo-type is not a class and never carried
 * a backslash to begin with. {@see self::protectPseudoTypes()} undoes that
 * one case after `simplifyType()` runs, so a class reference beside a
 * pseudo-type in the same structural type still shortens correctly.
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

        return self::protectPseudoTypes($namespace->simplifyType($docType));
    }

    /**
     * Strips the stray leading backslash `simplifyType()` just added to a
     * name on the closed PHPStan pseudo-type vocabulary — `list<non-empty-string>`
     * puts a pseudo-type inside the structural slot for the first time
     * (`refine-list-item-types-from-the-item-schema-constraints`), so this is
     * the one place `shorten()` has to learn the difference between a
     * pseudo-type and a class name it left unqualified.
     *
     * The vocabulary is {@see PhpDocTypeCompatibility::BASE_OF}'s keys, read
     * through reflection rather than duplicated here: a second list could
     * drift out of step with the one that already exists
     * (`phpdoctypes-stays-scalar-only`), and `PhpDocTypeCompatibility` itself
     * is outside this change's file boundary, so reflection is how this
     * class reaches the existing vocabulary instead of widening its
     * visibility.
     */
    private static function protectPseudoTypes(string $docType): string
    {
        $names = self::pseudoTypeNames();

        if ($names === []) {
            return $docType;
        }

        $pattern = '~\\\\(' . implode('|', array_map(
            static fn(string $name): string => preg_quote($name, '~'),
            $names,
        )) . ')\b~';

        return preg_replace($pattern, '$1', $docType) ?? $docType;
    }

    /**
     * @return list<string>
     */
    private static function pseudoTypeNames(): array
    {
        /** @var list<string>|null $names */
        static $names = null;

        if ($names !== null) {
            return $names;
        }

        $constant = new ReflectionClassConstant(PhpDocTypeCompatibility::class, 'BASE_OF');
        $baseOf = $constant->getValue();

        if (!is_array($baseOf)) {
            return [];
        }

        $collected = [];

        foreach (array_keys($baseOf) as $key) {
            if (is_string($key)) {
                $collected[] = $key;
            }
        }

        $names = $collected;

        return $names;
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
        return count(self::topLevelMembers($docType)) > 1;
    }

    /**
     * The union's members at bracket depth zero, or the whole string as a
     * single member when it is not a union. Splitting on a bare `explode('|')`
     * would tear `array<string, int|null>` in half, so the same depth-aware
     * reading {@see isTopLevelUnion} needs is the one that yields the parts —
     * one implementation, two questions.
     *
     * @return list<string>
     */
    public static function topLevelMembers(string $docType): array
    {
        $members = [];
        $current = '';
        $depth = 0;

        foreach (str_split($docType) as $char) {
            $depth += match ($char) {
                '<' => 1,
                '>' => -1,
                default => 0,
            };

            if ($char === '|' && $depth === 0) {
                $members[] = $current;
                $current = '';

                continue;
            }

            $current .= $char;
        }

        $members[] = $current;

        return $members;
    }
}
