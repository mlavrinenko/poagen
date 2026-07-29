<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use Nette\PhpGenerator\Method;

/**
 * Attaches a request's active security schemes to the emitted method body:
 * header-kind schemes as PSR-7 headers, query-kind schemes as entries in
 * the `$query` array {@see RequestAssembler::emitQueryAssembly()} folds
 * into the path's query string.
 *
 * Split out of {@see RequestAssembler} so that class stays under ADR-004's
 * 250-line cap once query-string credentials join header ones.
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

    /**
     * Push one query-kind scheme's credential onto the `$query` array.
     * Caller guarantees `$query` already exists in the emitted method body.
     */
    public function emitQueryPush(Method $method, SecurityScheme $scheme): void
    {
        $method->addBody(
            '$query[] = ? . \urlencode($this->' . $scheme->ctorArg . ');',
            [$scheme->wireName . '='],
        );
    }

    /**
     * Attach each header-kind active security scheme as a header. Runs
     * after the per-parameter header loop so auth headers consistently
     * land last in the emitted method body — makes request diffs
     * predictable and matches the "auth is transport policy" framing of
     * ADR-002.
     *
     * @param list<SecurityScheme> $activeSchemes
     */
    public function emitHeaders(Method $method, array $activeSchemes): void
    {
        foreach ($activeSchemes as $scheme) {
            switch ($scheme->kind) {
                case SecurityScheme::KIND_API_KEY_HEADER:
                    $method->addBody(
                        '$request = $request->withHeader(?, $this->' . $scheme->ctorArg . ');',
                        [$scheme->wireName],
                    );
                    break;

                case SecurityScheme::KIND_BEARER:
                    $method->addBody(
                        '$request = $request->withHeader(?, ? . $this->' . $scheme->ctorArg . ');',
                        [$scheme->wireName, 'Bearer '],
                    );
                    break;
            }
        }
    }
}
