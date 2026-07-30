<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use function sprintf;
use function var_export;

/**
 * The chain segments that put an operation's active credentials on the
 * request: header-kind schemes as headers, query-kind schemes as query keys.
 *
 * A credential is unconditional — an active scheme is always sent — so it
 * needs no null branch, and a query credential joins the same query bag a
 * declared parameter does. That is what keeps one `?` in the request target
 * whether or not the operation has query parameters of its own.
 *
 * Credential segments come last of their kind, after the declared parameters,
 * so request diffs stay predictable and auth reads as the transport policy
 * ADR-002 frames it as.
 *
 * @internal
 */
final readonly class SecurityEmitter
{
    /**
     * The active schemes that belong in the query string rather than a
     * header — currently only {@see SecurityScheme::KIND_API_KEY_QUERY}.
     *
     * @param list<SecurityScheme> $activeSchemes
     *
     * @return list<SecurityScheme>
     */
    public function querySchemes(array $activeSchemes): array
    {
        return array_values(array_filter(
            $activeSchemes,
            static fn(SecurityScheme $scheme): bool => $scheme->kind === SecurityScheme::KIND_API_KEY_QUERY,
        ));
    }

    public function querySegment(SecurityScheme $scheme): string
    {
        return sprintf('->query(%s, $this->%s)', var_export($scheme->wireName, true), $scheme->ctorArg);
    }

    /**
     * @param list<SecurityScheme> $activeSchemes
     *
     * @return list<string>
     */
    public function headerSegments(array $activeSchemes): array
    {
        $segments = [];

        foreach ($activeSchemes as $scheme) {
            $name = var_export($scheme->wireName, true);

            switch ($scheme->kind) {
                case SecurityScheme::KIND_API_KEY_HEADER:
                    $segments[] = sprintf('->header(%s, $this->%s)', $name, $scheme->ctorArg);
                    break;

                case SecurityScheme::KIND_BEARER:
                    $segments[] = sprintf("->header(%s, 'Bearer ' . \$this->%s)", $name, $scheme->ctorArg);
                    break;
            }
        }

        return $segments;
    }
}
