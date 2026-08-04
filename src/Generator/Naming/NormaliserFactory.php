<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Naming;

use Poagen\Generator\Generator\Profile;

/**
 * Build the default `NameNormaliser` pipeline from a {@see Profile}.
 *
 * Precedence: explicit `Profile::$nameNormaliser` wins and is used verbatim.
 * Otherwise the factory composes the profile's rename maps — each scoped to the
 * one {@see SymbolKind} it names — ahead of the two sanitisers. See
 * `typed-profile-and-colocated-attributes` (T-023).
 *
 * The scoping matters because the maps answer different questions.
 * `$renames` names payload classes, `$methodRenames` names client methods; a
 * document may legitimately use one string for both a component and an
 * operation, and an unscoped map would apply a consumer's answer to the wrong
 * one.
 */
final readonly class NormaliserFactory
{
    public static function fromProfile(Profile $profile): NameNormaliser
    {
        if ($profile->nameNormaliser instanceof NameNormaliser) {
            return $profile->nameNormaliser;
        }

        $strategies = [];

        if ($profile->renames !== []) {
            $strategies[] = new RenamesNormaliser($profile->renames, kind: SymbolKind::SchemaComponent, label: 'renames');
        }
        if ($profile->methodRenames !== []) {
            $strategies[] = new RenamesNormaliser($profile->methodRenames, kind: SymbolKind::OperationId, label: 'methodRenames');
        }
        if ($profile->tagRenames !== []) {
            $strategies[] = new RenamesNormaliser($profile->tagRenames, kind: SymbolKind::Tag, label: 'tagRenames');
        }

        // Both sanitisers self-filter on `SymbolKind`. The composite walks
        // them in order, the matching one returns the normalised name,
        // the other returns `null` and falls through.
        $strategies[] = new PascalCaseSanitiser();
        $strategies[] = new CamelCaseSanitiser();

        return new CompositeNormaliser($strategies);
    }
}
