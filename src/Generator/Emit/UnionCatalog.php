<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Bindings;
use Mlavrinenko\Paogen\Generator\Generator;
use Mlavrinenko\Paogen\Generator\UnionGuidanceValidator;

use const SORT_STRING;

/**
 * Everything one run learned about the document's property-level unions: how
 * each one picks a branch, and which ones it could not resolve at all.
 *
 * Indexed twice over the same objects, because two callers ask different
 * questions. {@see ModelAttributeApplier} holds a property's `Schema` and
 * nothing else, so it looks up by JSON pointer — the one identity a schema node
 * carries about itself, derived through {@see SynthesisedModel::originOf} so
 * the two readings cannot drift apart. The guidance validators hold a profile
 * key, so they look up by `'<Component>.<property>'`.
 *
 * Reaches the emitter on {@see Bindings}, which
 * is already threaded to every site that needs it. Adding a parameter to
 * `ModelPlanner::plan()` instead would have been the obvious route and is not
 * available: that file sits at 245 of linecop's 250 lines.
 *
 * @internal
 */
final readonly class UnionCatalog
{
    /**
     * @param array<string,UnionResolution> $byPointer document position => how that union picks a branch
     * @param array<string,UnionResolution> $byKey     '<Component>.<property>' => the same objects
     * @param list<SkippedComponent>        $failures  unions no layer could resolve, keyed by the component
     *                                                 that carries them — the granularity `Profile::$skip`
     *                                                 already uses, so an unresolvable union stays acceptable
     *                                                 by naming its component the way every other refusal is
     */
    public function __construct(
        private array $byPointer = [],
        private array $byKey = [],
        private array $failures = [],
    ) {}

    /**
     * One catalog from two — {@see UnionGuidanceValidator}
     * and {@see Generator} read a single
     * `UnionCatalog`, but property-position unions
     * ({@see DiscriminatorEnforcer}) and
     * response-position ones
     * ({@see ResponseUnionPlanner}) are
     * resolved by two different passes over the document — the second needs
     * a `ModelNameLedger` per operation that only exists inside
     * {@see InlinePayloadPlanner}'s own
     * walk. Combining the two here, rather than teaching one pass about the
     * other's bookkeeping, is what keeps "one mechanism, one set of rules"
     * true without merging the passes themselves.
     */
    public static function merge(self $a, self $b): self
    {
        return new self(
            [...$a->byPointer, ...$b->byPointer],
            [...$a->byKey, ...$b->byKey],
            [...$a->failures, ...$b->failures],
        );
    }

    public function for(Schema $propertySchema): ?UnionResolution
    {
        return $this->byPointer[SynthesisedModel::originOf($propertySchema)] ?? null;
    }

    /**
     * The layer that resolved the named union, or null when nothing did — it
     * either needed guidance nobody supplied, or the document does not carry
     * that union at all. A pin is stale exactly when this answers with a kind
     * that is not {@see UnionResolution::KIND_PIN}.
     */
    public function kindFor(string $key): ?string
    {
        return ($this->byKey[$key] ?? null)?->kind;
    }

    /**
     * @return list<SkippedComponent>
     */
    public function failures(): array
    {
        return $this->failures;
    }

    /**
     * One line per union, ordered by document position so the order is a fact
     * about the document rather than about iteration.
     *
     * @return list<string>
     */
    public function notices(): array
    {
        $positions = array_keys($this->byPointer);
        sort($positions, SORT_STRING);

        $out = [];

        foreach ($positions as $position) {
            $out[] = $this->byPointer[$position]->notice;
        }

        return $out;
    }
}
