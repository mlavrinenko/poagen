<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator;

use Mlavrinenko\Paogen\Generator\Emit\DiscriminatorEnforcer;
use Mlavrinenko\Paogen\Generator\Emit\UnionCatalog;
use Mlavrinenko\Paogen\Runtime\ScalarBinding;

/**
 * What the emitters must look up per node and cannot read off the schema,
 * indexed for O(1) lookup at emit time.
 *
 * Two things qualify. The user-side type bindings discovered by scanning the
 * consumer's own namespaces, and the branch-selection each property-level union
 * resolved to — computed once against the whole document, then needed one
 * property at a time by an emitter that holds only that property's node.
 *
 * The union catalog rides here rather than as a parameter of its own because
 * this object is already threaded to every site that needs it, down to
 * `ModelAttributeApplier::apply()`. The obvious alternative, another parameter
 * on `ModelPlanner::plan()`, is not available: that file sits at 245 of
 * linecop's 250 lines.
 */
final readonly class Bindings
{
    /**
     * @param array<string,class-string> $formats Map of OpenAPI format → user value-object FQCN.
     * @param UnionCatalog               $unions  How each property-level union picks a branch.
     */
    public function __construct(
        public array $formats,
        public UnionCatalog $unions = new UnionCatalog(),
    ) {}

    /**
     * The same bindings with the run's resolved unions attached. Called once,
     * after {@see DiscriminatorEnforcer} has
     * read the whole document — the scan that produces the format bindings runs
     * before the document is even parsed, so the two cannot be built together.
     */
    public function withUnions(UnionCatalog $unions): self
    {
        return new self($this->formats, $unions);
    }

    public function formatType(string $format): ?string
    {
        return $this->formats[$format] ?? null;
    }

    /**
     * Return the bound FQCN for `$format` only when that VO opts into the
     * transparent scalar round-trip contract of
     * `hydration-and-serialization-contract`.
     *
     * @return class-string<ScalarBinding>|null
     */
    public function scalarBindingType(string $format): ?string
    {
        $fqcn = $this->formats[$format] ?? null;

        if ($fqcn === null) {
            return null;
        }

        if (!is_a($fqcn, ScalarBinding::class, true)) {
            return null;
        }

        /** @var class-string<ScalarBinding> $fqcn */
        return $fqcn;
    }

    /**
     * Resolve a `format` to a scalar-boundary binding: a user VO implementing
     * {@see ScalarBinding} if one is registered, otherwise a paogen built-in
     * (currently `date-time` and `date` → `\DateTimeImmutable`). User bindings
     * always win so consumers can swap in Carbon, Chronos, etc.
     */
    public function scalarFormat(string $format): ?ScalarFormat
    {
        $userBinding = $this->scalarBindingType($format);

        if ($userBinding !== null) {
            return ScalarFormat::userScalar($userBinding);
        }

        // User-registered non-ScalarBinding VO (object binding) stays on the
        // whole-object path — not a scalar format.
        if (isset($this->formats[$format])) {
            return null;
        }

        return match ($format) {
            'date-time' => ScalarFormat::dateTime(),
            'date' => ScalarFormat::date(),
            default => null,
        };
    }
}
