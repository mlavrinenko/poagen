<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Schema;

/**
 * The result of {@see AllOfMerger::merge()} — exactly one of three shapes:
 *
 *   - a single synthesised {@see Schema}, the recursive union of the node's
 *     own `properties`/`required` and every member's;
 *   - a list of {@see AllOfBranch}, when exactly one member was a
 *     `oneOf`/`anyOf` whose branches are all expressible object shapes —
 *     one synthesised model per branch, and a PHP union across them at the
 *     call site (the ruling `an anyOf member becomes a union of branches,
 *     not a dropped constraint`);
 *   - a refusal reason, naming the property, member or schema pointer
 *     `allOf` could not merge. Never silently dropped
 *     (abort-on-unrepresentable-constructs) — the caller turns this into a
 *     {@see SkippedOperation} reason, and `Profile::$skip` is where a
 *     consumer says they do not need the operation.
 *
 * @internal
 */
final readonly class AllOfMerge
{
    /**
     * @param list<AllOfBranch>|null $branches
     */
    private function __construct(
        public ?Schema $schema,
        public ?array $branches,
        public ?string $refusal,
    ) {}

    public static function object(Schema $schema): self
    {
        return new self($schema, null, null);
    }

    /**
     * @param list<AllOfBranch> $branches
     */
    public static function union(array $branches): self
    {
        return new self(null, $branches, null);
    }

    public static function refused(string $reason): self
    {
        return new self(null, null, $reason);
    }

    public function isUnion(): bool
    {
        return $this->branches !== null;
    }

    public function isRefused(): bool
    {
        return $this->refusal !== null;
    }
}
