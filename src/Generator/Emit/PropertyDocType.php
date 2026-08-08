<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Nette\PhpGenerator\PhpNamespace;

use function sprintf;
use function str_ends_with;

/**
 * The `@param` line one model property contributes to the constructor's doc
 * comment — or the reason it contributes none.
 *
 * Three sources feed one slot, in priority order. A structural doc type
 * (`list<Tag>`, `array<string, mixed>`) the resolver produced wins it and is
 * shortened against the namespace so its class references print short. Where
 * the resolver left none, a scalar property may still carry a narrower type
 * than its bare `string` / `int` — from an OpenAPI constraint, or a profile
 * override OpenAPI cannot spell (`refined-phpdoc-types`). Those are PHPStan
 * pseudo-types (`non-empty-string`, `positive-int`, `numeric-string`) with no
 * class to resolve, so they pass through raw: running them through
 * {@see DocTypeSimplifier::shorten()} makes nette read them as class names and
 * prefix a stray leading backslash.
 *
 * An override that cannot reach the slot is a failure, not a silent drop —
 * see {@see PhpDocTypeCompatibility}, which is asked before anything is
 * emitted, so a profile that would produce a PHPStan-broken model fails the
 * run instead.
 *
 * @internal
 */
final readonly class PropertyDocType
{
    private function __construct(
        public ?string $comment,
        public ?string $failure,
    ) {}

    /**
     * @param string      $key      the `'<RawComponentName>.<wirePropertyName>'` the override was keyed by
     * @param string|null $override the `Profile::$phpDocTypes` entry for this property, if any
     */
    public static function of(
        PhpNamespace $namespace,
        TypeResolver $resolved,
        Schema|Reference $schema,
        string $key,
        ?string $override,
        bool $isNullable,
        string $phpName,
    ): self {
        if ($override !== null && $override !== '') {
            $failure = PhpDocTypeCompatibility::reject($key, $override, $resolved->phpType, $resolved->phpDoc);

            if ($failure !== null) {
                return new self(null, $failure);
            }
        }

        $docType = $resolved->phpDoc !== null
            ? DocTypeSimplifier::shorten($namespace, $resolved->phpDoc)
            : PhpDocTypeRefiner::refine($resolved->phpType, $schema, $override);

        if ($docType === null) {
            return new self(null, null);
        }

        return new self(sprintf('@param %s $%s', self::nullable($docType, $isNullable), $phpName), null);
    }

    /**
     * `?string|list<string>` is not a type PHPStan reads as "the whole union,
     * nullable" — a union doc type needs `|null` appended, not `?` prefixed.
     */
    private static function nullable(string $docType, bool $isNullable): string
    {
        $union = DocTypeSimplifier::isTopLevelUnion($docType);

        return match (true) {
            !$isNullable => $docType,
            $union && !str_ends_with($docType, '|null') => $docType . '|null',
            $union => $docType,
            default => '?' . $docType,
        };
    }
}
