<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Schema;

/**
 * One reading of a schema's `type`, whichever of its two spellings the document
 * used.
 *
 * JSON Schema — and OpenAPI 3.1 with it — lets `type` be a list, and the
 * overwhelmingly common list is `[T, "null"]`, which is how a 3.1 document says
 * what a 3.0 document said with `nullable: true`. Every `is_string($schema->type)`
 * guard in the generator missed that spelling and fell through to `mixed`, so a
 * property the vendor had typed reached the consumer untyped and nothing said
 * so. Reading it in one place is what keeps the two spellings from diverging
 * again.
 *
 * Three outcomes, and the third is a refusal:
 *
 *   - one non-`"null"` member → that type, nullable if `"null"` sat beside it;
 *   - several members, all scalar → a PHP union of them, because PHP can say
 *     `string|int` and a union is strictly more of the schema represented than
 *     `mixed` is;
 *   - several members including `object` or `array` → nothing this class can
 *     name. There is no single class for an inline object member and no single
 *     item type for an array member, so {@see TypeListScanner} reports it and
 *     the run stops rather than emitting a permissive type.
 *
 * @internal
 */
final readonly class SchemaType
{
    public const array SCALARS = ['string', 'integer', 'number', 'boolean'];

    private const string NULL = 'null';

    /** @var array<string,string> */
    private const array PHP_BY_JSON = [
        'string' => 'string',
        'integer' => 'int',
        'number' => 'float',
        'boolean' => 'bool',
    ];

    /**
     * @param string|null  $name    the single member, when there is exactly one; null when the
     *                              document declared no type, or declared several
     * @param list<string> $members every non-`"null"` member, in declaration order
     */
    private function __construct(
        public ?string $name,
        public bool $nullable,
        public array $members,
    ) {}

    public static function of(Schema $schema): self
    {
        $raw = self::rawType($schema);

        if (\is_string($raw)) {
            return new self($raw === '' ? null : $raw, false, $raw === '' ? [] : [$raw]);
        }

        if (!\is_array($raw)) {
            return new self(null, false, []);
        }

        $members = [];
        $nullable = false;

        foreach ($raw as $member) {
            if (!\is_string($member)) {
                continue;
            }
            if ($member === '') {
                continue;
            }
            if ($member === self::NULL) {
                $nullable = true;
                continue;
            }
            $members[] = $member;
        }

        return new self(\count($members) === 1 ? $members[0] : null, $nullable, $members);
    }

    /**
     * cebe declares `Schema::$type` as `string` in the magic-property docblock
     * it resolves properties through, but JSON Schema allows a list and the
     * parser hands the list over verbatim as a PHP array. Widening at this one
     * boundary is what lets the reader above narrow honestly, instead of the
     * analyser insisting the array branch is unreachable.
     */
    private static function rawType(Schema $schema): mixed
    {
        return $schema->type;
    }

    /**
     * True when the document named several types and every one of them is a
     * scalar — the case PHP can express as a union.
     */
    public function isScalarUnion(): bool
    {
        if (\count($this->members) < 2) {
            return false;
        }
        return array_all($this->members, fn($member): bool => \in_array($member, self::SCALARS, true));
    }

    /**
     * True when the document named several types and at least one of them is
     * not a scalar. Nothing here can name it, so it is a refusal.
     */
    public function isUnrepresentable(): bool
    {
        return \count($this->members) >= 2 && !$this->isScalarUnion();
    }

    /**
     * The PHP union for {@see isScalarUnion()}, ordered as the document
     * declared it so a reordering upstream is visible in the diff and a
     * reordering here is not. Null suffixes it when `"null"` was a member.
     */
    public function unionPhpType(): string
    {
        $parts = array_map(static fn(string $m): string => self::PHP_BY_JSON[$m] ?? 'mixed', $this->members);

        return implode('|', $parts) . ($this->nullable ? '|null' : '');
    }

    /**
     * The single member's PHP type, or null when this is not a single scalar.
     */
    public function scalarPhpType(): ?string
    {
        return $this->name === null ? null : (self::PHP_BY_JSON[$this->name] ?? null);
    }

    public function is(string $jsonType): bool
    {
        return $this->name === $jsonType;
    }

    public function isScalar(): bool
    {
        return $this->scalarName() !== null;
    }

    /**
     * The member name when it is one of the four JSON scalars, narrowed so a
     * caller storing it need not re-check.
     *
     * @return 'string'|'integer'|'number'|'boolean'|null
     */
    public function scalarName(): ?string
    {
        return match ($this->name) {
            'string' => 'string',
            'integer' => 'integer',
            'number' => 'number',
            'boolean' => 'boolean',
            default => null,
        };
    }

    /**
     * How the document spelled it, for a diagnostic.
     */
    public function describe(): string
    {
        return $this->members === []
            ? ($this->nullable ? 'null' : 'unspecified')
            : implode(', ', [...$this->members, ...($this->nullable ? [self::NULL] : [])]);
    }
}
