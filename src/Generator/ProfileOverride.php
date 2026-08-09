<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator;

/**
 * The single hand-enumerated copy of every {@see Profile} field, applied by
 * {@see Profile::with()} to replace `$output` and/or `$source` while
 * carrying everything else forward untouched.
 *
 * It used to live in `GenerateCommand`, one file away, and rotted twice —
 * `$inlineModels`, then the tag maps and `$xmlElements`, each added to the
 * constructor and silently not carried, so a `--output` run quietly
 * discarded the consumer's guidance and reported success. A second copy for
 * `$source` would have been a third chance at the same bug; there is one
 * copy now, and `OutputOverrideCarriesEveryProfileFieldTest` reflects over
 * `Profile`'s constructor to fail when a field skips it.
 *
 * Moved out of {@see Profile}, which had nowhere left to put it once
 * linecop's line count caught up with it (`quality-gates-at-maximum-strictness`).
 *
 * @internal
 */
final readonly class ProfileOverride
{
    public static function apply(Profile $profile, ?string $output, ?string $source): Profile
    {
        return new Profile(
            schema: $profile->schema,
            output: $output ?? $profile->output,
            namespace: $profile->namespace,
            discoverIn: $profile->discoverIn,
            renames: $profile->renames,
            nameNormaliser: $profile->nameNormaliser,
            discriminators: $profile->discriminators,
            unionTags: $profile->unionTags,
            unionPins: $profile->unionPins,
            skip: $profile->skip,
            methodRenames: $profile->methodRenames,
            tagRenames: $profile->tagRenames,
            tagAssignments: $profile->tagAssignments,
            tagChoice: $profile->tagChoice,
            xmlElements: $profile->xmlElements,
            inlineModels: $profile->inlineModels,
            propertyRenames: $profile->propertyRenames,
            phpDocTypes: $profile->phpDocTypes,
            formats: $profile->formats,
            propertyFormats: $profile->propertyFormats,
            securitySchemes: $profile->securitySchemes,
            source: $source ?? $profile->source,
        );
    }
}
