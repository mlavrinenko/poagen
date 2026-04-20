<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Naming;

use Mlavrinenko\Paogen\Generator\Profile;

/**
 * Build the default `NameNormaliser` pipeline from a {@see Profile}.
 *
 * Precedence: explicit `Profile::$nameNormaliser` wins. Otherwise the
 * factory composes `RenamesNormaliser($profile->renames)` (when
 * non-empty) followed by `PascalCaseSanitiser`. See ADR-003 (T-023).
 */
final readonly class NormaliserFactory
{
    public static function fromProfile(Profile $profile): NameNormaliser
    {
        if ($profile->nameNormaliser instanceof \Mlavrinenko\Paogen\Generator\Naming\NameNormaliser) {
            return $profile->nameNormaliser;
        }

        $strategies = [];
        if ($profile->renames !== []) {
            $strategies[] = new RenamesNormaliser($profile->renames);
        }
        // Both sanitisers self-filter on `SymbolKind`. The composite walks
        // them in order, the matching one returns the normalised name,
        // the other returns `null` and falls through.
        $strategies[] = new PascalCaseSanitiser();
        $strategies[] = new CamelCaseSanitiser();

        return new CompositeNormaliser($strategies);
    }
}
