<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Naming;

/**
 * Sibling of {@see PascalCaseSanitiser} for {@see SymbolKind::OperationId}
 * and {@see SymbolKind::ParameterName}.
 *
 * Operation IDs and parameter names map to PHP method names and method
 * parameters respectively — both conventionally camelCase, not PascalCase.
 * Splits on `[^A-Za-z0-9]+`, lowercases the first segment, PascalCases the
 * rest, and prefixes an underscore when the result starts with a digit.
 *
 * Returns `null` for any other {@see SymbolKind} so a composite pipeline
 * can dispatch the matching kind to the matching strategy.
 */
final readonly class CamelCaseSanitiser implements NameNormaliser
{
    /** "Already a valid camelCase identifier" — passthrough. */
    private const string CAMEL_CASE = '/^[a-z_]\w*$/';

    public function normalise(string $raw, NormalisationContext $context): ?string
    {
        if (!\in_array($context->kind, [SymbolKind::OperationId, SymbolKind::ParameterName], true)) {
            return null;
        }

        if (preg_match(self::CAMEL_CASE, $raw) === 1) {
            return $raw;
        }

        // Insert an explicit boundary at every lowercase→uppercase
        // transition so camelCase input (`findPetsByStatus`) splits
        // cleanly before the join pass.
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
            $lower = strtolower($segment);
            $cased[] = $cased === [] ? $lower : ucfirst($lower);
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
