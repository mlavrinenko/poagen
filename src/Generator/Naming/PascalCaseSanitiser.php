<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Naming;

use function in_array;

/**
 * Splits the raw name on `[^A-Za-z0-9]+`, PascalCases each segment,
 * and prefixes an underscore when the result starts with a digit.
 *
 * Already-valid PHP identifiers (`ApiResponse`, `Pet`) pass through
 * unchanged so the strategy is safe to use as the catch-all in the
 * default pipeline without churning byte-stable schemas.
 *
 * Returns null when:
 *   - an optional pattern is set and the raw name does not match it,
 *   - the input contains no characters worth keeping (`'-'`, `''`).
 *
 * Either case lets the composite either fall through to the next
 * strategy or — at the end of the pipeline — surface a pointed
 * error with the raw name.
 */
final readonly class PascalCaseSanitiser implements NameNormaliser
{
    /**
     * "Already PascalCase" — starts with an uppercase letter and uses
     * only [A-Za-z0-9]. `app_alert` matches the PHP identifier grammar
     * but is *not* PascalCase, so it still gets transformed.
     */
    private const string PASCAL_CASE = '/^[A-Z][A-Za-z0-9]*$/';

    public function __construct(
        private ?string $pattern = null,
    ) {}

    public function normalise(string $raw, NormalisationContext $context): ?string
    {
        // OperationId and ParameterName route through CamelCaseSanitiser
        // — PHP method and parameter names are conventionally camelCase
        // (`findPetsByStatus`, `$petId`), never PascalCase. A Tag names a
        // sub-client class, so it belongs here.
        if (!in_array($context->kind, [SymbolKind::SchemaComponent, SymbolKind::Tag], true)) {
            return null;
        }

        if ($this->pattern !== null && preg_match($this->pattern, $raw) !== 1) {
            return null;
        }

        if (preg_match(self::PASCAL_CASE, $raw) === 1) {
            return $raw;
        }

        // Fold non-ASCII letters to ASCII before splitting: the split below
        // keeps only [A-Za-z0-9], so a Cyrillic tag would otherwise reduce to
        // nothing at all rather than to a readable name.
        $raw = AsciiFolder::fold($raw);

        // Insert an explicit boundary at every lowercase→uppercase
        // transition so camelCase input (`findPetsByStatus`) splits
        // cleanly before the join pass — otherwise one segment with
        // mixed case collapses to `Findpetsbystatus`.
        $withBoundaries = (string) preg_replace('/([a-z0-9])([A-Z])/', '$1_$2', $raw);
        $segments = preg_split('/[^A-Za-z0-9]+/', $withBoundaries);

        if ($segments === false) {
            return null;
        }

        $cased = [];

        foreach ($segments as $segment) {
            if ($segment === '') {
                continue;
            }
            $cased[] = ucfirst(strtolower($segment));
        }

        if ($cased === []) {
            return null;
        }

        $joined = implode('', $cased);

        if (preg_match('/^\d/', $joined) === 1) {
            return '_' . $joined;
        }

        return $joined;
    }
}
