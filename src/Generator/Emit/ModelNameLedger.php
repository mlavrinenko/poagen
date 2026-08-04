<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use Mlavrinenko\Paogen\Exception\ModelNameCollisionException;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;

/**
 * Records which schema node owns each emitted model class name, for the one
 * namespace they all share.
 *
 * {@see NameRegistry} already guards the
 * names that come from `components.schemas`, because those are declared and it
 * can key on the raw name. Synthesised names have no raw name to key on: they
 * are derived from an operation identifier, or from an owning class plus a
 * property, and two unrelated derivations can meet on one identifier. This
 * ledger closes that gap by keying on the emitted name and remembering where
 * the claim came from, so a collision fails the run with both origins named
 * instead of one file quietly describing two shapes.
 *
 * An origin is a human-readable location — a JSON pointer into the document,
 * or a component name. Claiming the same name twice from the same origin is
 * idempotent, so a caller need not track whether it has already claimed.
 *
 * @internal
 */
final class ModelNameLedger
{
    /** @var array<string,string> emitted PHP class name → origin description */
    private array $claims = [];

    /** @var array<string,true> names claimed through {@see claimMerge()} */
    private array $merged = [];

    public function claim(string $phpName, string $origin): void
    {
        $existing = $this->claims[$phpName] ?? null;

        if ($existing !== null && $existing !== $origin) {
            throw ModelNameCollisionException::between($phpName, $existing, $origin);
        }

        $this->claims[$phpName] = $origin;
    }

    /**
     * Claims a name a `Profile::$inlineModels` entry may legitimately name
     * from several sites at once — a merge
     * (name-inline-schemas-by-operation-and-status). Returns true the first
     * time, when the caller should emit the class; false every time after,
     * when the caller must reuse the name rather than emit a second file or
     * claim it again through {@see claim()}, which would read the second
     * site as an accidental collision rather than a deliberate merge.
     *
     * Safe to trust without re-comparing the schema here: a merge only
     * reaches this method after `InlineModelMergeValidator` has already
     * proven every site in the group emits the identical shape, so which
     * site's origin ends up recorded makes no difference to what the class
     * describes.
     */
    public function claimMerge(string $phpName, string $origin): bool
    {
        if (isset($this->merged[$phpName])) {
            return false;
        }

        $this->merged[$phpName] = true;
        $this->claim($phpName, $origin);

        return true;
    }
}
