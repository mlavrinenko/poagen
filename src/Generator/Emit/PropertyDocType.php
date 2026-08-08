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
 * (`list<Tag>`, `array<string, mixed>`) the resolver produced wins it. A
 * plain single-level list of scalars — `list<string>`, `list<int>` — is
 * first offered to {@see PhpDocTypeRefiner::refineListItem()}, which reads
 * the same `minLength` / `minimum` constraints one level into the property's
 * `items` schema that a bare scalar property already narrows on its own
 * (`refine-list-item-types-from-the-item-schema-constraints`); every other
 * structural shape passes through unrefined. What results is shortened
 * against the namespace so any class reference inside it prints short. Where
 * the resolver left the slot empty, a scalar property may still carry a
 * narrower type than its bare `string` / `int` — from an OpenAPI constraint,
 * or a profile override OpenAPI cannot spell (`refined-phpdoc-types`).
 *
 * Both paths can land a PHPStan pseudo-type (`non-empty-string`,
 * `positive-int`, `numeric-string`) inside the doc string that reaches
 * {@see DocTypeSimplifier::shorten()} — a pseudo-type has no class to
 * resolve, and `shorten()` knows the closed vocabulary and leaves one alone
 * rather than reading it as a class name and prefixing a stray leading
 * backslash.
 *
 * An override that cannot reach the slot is a failure, not a silent drop —
 * see {@see PhpDocTypeCompatibility}, which is asked before anything is
 * emitted, against the structural type the property would actually carry
 * once list-item refinement has run, so a profile that would produce a
 * PHPStan-broken model fails the run instead.
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
        // A plain list of scalars may narrow one level into `items` before
        // anything else looks at the structural slot, so a refusal below
        // names the type the property actually ends up carrying rather than
        // the one TypeResolver first resolved.
        $structural = $resolved->phpDoc !== null
            ? PhpDocTypeRefiner::refineListItem($schema, $resolved->phpDoc) ?? $resolved->phpDoc
            : null;

        if ($override !== null && $override !== '') {
            $failure = PhpDocTypeCompatibility::reject($key, $override, $resolved->phpType, $structural);

            if ($failure !== null) {
                return new self(null, $failure);
            }
        }

        $docType = $structural !== null
            ? DocTypeSimplifier::shorten($namespace, $structural)
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
