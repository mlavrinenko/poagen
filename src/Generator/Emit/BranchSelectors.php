<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;

use function count;
use function implode;
use function sprintf;

use const SORT_STRING;

/**
 * Which field, if any, decides each branch of a union — computed at generation
 * time from what the document declares, never guessed at runtime.
 *
 * The rule, and why it is not strict JSON Schema validation. Under validation
 * semantics the question is "could this payload satisfy two branches", and on a
 * real document the answer is almost always yes: of the fifty-two branch
 * schemas across both large vendor documents, exactly one declares
 * `additionalProperties: false`, so every other branch tolerates unknown keys
 * and a payload carrying two branches' required fields validates against both.
 * That reading is correct and it is the wrong question here. Vendors send one
 * branch. The question worth answering is *does this payload carry a field only
 * one branch declares*, and under that reading most real unions resolve.
 *
 * So a branch is decided by a field it **requires** that no *other* branch
 * **declares at all**. Requiring it makes the field a promise about payloads of
 * that branch; nobody else declaring it makes the field's presence decisive.
 * Exactly one such field is kept per branch — the alphabetically first, so the
 * choice is a fact about the field names rather than about the document's key
 * order, and a re-run emits the same bytes. Keeping all of them would make a
 * vendor who omits one field despite declaring it required fail to match at
 * all, for no gain: one exclusive field already names the branch.
 *
 * A second predicate covers the one shape the first cannot see. A branch that
 * declares no properties and closes itself with `additionalProperties: false`
 * accepts `{}` and nothing else, so it is decided by the *absence* of fields.
 * GitHub's `empty-object` is the only branch schema of the fifty-two that
 * qualifies, and it is what makes `commit.author` and `commit.committer`
 * decidable — under the required-field rule alone they are not, because
 * `empty-object` requires nothing.
 *
 * Undecidable branches are reported, not resolved. Two branches sharing every
 * discriminating field is the refusal this class exists to detect.
 *
 * @internal
 */
final readonly class BranchSelectors
{
    /**
     * @param array<string,string> $fields      raw branch name => the one wire field whose presence selects it
     * @param string|null          $empty       raw branch name selected by an empty payload
     * @param list<string>         $undecidable raw branch names no payload could single out
     */
    private function __construct(
        public array $fields,
        public ?string $empty,
        public array $undecidable,
    ) {}

    /**
     * @param list<Reference> $branches
     */
    public static function compute(array $branches, OpenApi $openApi): self
    {
        // A component name that reads as a number becomes an int key in PHP, so
        // every key read back out is cast rather than assumed — the same trap
        // ModelEmitter already guards when it orders a schema's properties.
        /** @var array<array-key,EffectiveShape|null> $shapes */
        $shapes = [];

        foreach ($branches as $branch) {
            $name = ComponentName::rawFromRef($branch->getReference());
            $target = EffectiveShape::resolve($branch, $openApi);
            $shapes[$name] = $target instanceof Schema ? EffectiveShape::of($target, $openApi) : null;
        }

        return self::computeFromShapes($shapes);
    }

    /**
     * The core the property position's {@see compute()} builds its
     * `$shapes` map for and calls straight through to. Pulled out so a
     * caller who already has its branches resolved to shapes — a
     * response-position union, whose branches are not always a `$ref`
     * {@see ResponseUnionPlanner} — can
     * feed this the same map keyed by whatever identity it uses (a raw
     * component name here, a synthesised model name there) without
     * round-tripping through a `Reference` that does not exist for an
     * inline branch.
     *
     * @param array<array-key,EffectiveShape|null> $shapes
     */
    public static function computeFromShapes(array $shapes): self
    {
        $closed = self::soleClosedBranch($shapes);
        $fields = [];
        $undecidable = [];

        foreach ($shapes as $key => $shape) {
            $name = (string) $key;

            // The one branch a `{}` payload selects needs no field of its own,
            // and having none is exactly why it qualifies.
            if ($name === $closed) {
                continue;
            }

            $field = $shape instanceof EffectiveShape ? self::decidingField($name, $shape, $shapes) : null;

            if ($field === null) {
                $undecidable[] = $name;

                continue;
            }

            $fields[$name] = $field;
        }

        sort($undecidable, SORT_STRING);

        return new self($fields, $closed, $undecidable);
    }

    public function decidable(): bool
    {
        return $this->undecidable === [];
    }

    /**
     * One line naming what the run will discriminate on, so the rule is visible
     * before anything runs rather than discovered in production.
     */
    public function describe(): string
    {
        $parts = [];

        foreach ($this->fields as $branch => $field) {
            $parts[] = sprintf('`%s` -> %s', $field, $branch);
        }

        if ($this->empty !== null) {
            $parts[] = sprintf('%s on an empty payload (it declares `additionalProperties: false` and no properties)', $this->empty);
        }

        return implode(', ', $parts);
    }

    /**
     * The single branch a `{}` payload selects, or null. Two closed branches in
     * one union would both accept `{}`, so neither is decided by it and both
     * fall through to the undecidable list instead.
     *
     * @param array<array-key,EffectiveShape|null> $shapes
     */
    private static function soleClosedBranch(array $shapes): ?string
    {
        $closed = [];

        foreach ($shapes as $name => $shape) {
            if ($shape !== null && $shape->closed) {
                $closed[] = (string) $name;
            }
        }

        return count($closed) === 1 ? $closed[0] : null;
    }

    /**
     * @param array<array-key,EffectiveShape|null> $shapes
     */
    private static function decidingField(string $branch, EffectiveShape $shape, array $shapes): ?string
    {
        $exclusive = [];

        foreach (array_keys($shape->required) as $field) {
            if (self::isExclusive((string) $field, $branch, $shapes)) {
                $exclusive[] = (string) $field;
            }
        }

        if ($exclusive === []) {
            return null;
        }

        sort($exclusive, SORT_STRING);

        return $exclusive[0];
    }

    /**
     * @param array<array-key,EffectiveShape|null> $shapes
     */
    private static function isExclusive(string $field, string $branch, array $shapes): bool
    {
        foreach ($shapes as $name => $shape) {
            if ((string) $name === $branch) {
                continue;
            }

            if ($shape === null || isset($shape->declared[$field])) {
                return false;
            }
        }

        return true;
    }
}
