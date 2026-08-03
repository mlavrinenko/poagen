<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use Nette\PhpGenerator\PhpNamespace;

use function sprintf;
use function var_export;

/**
 * The chain segments that put an operation's active credentials on the
 * request: query-kind schemes as query keys, everything else as a header.
 *
 * Every wired kind is one credential reaching one place on the wire, so
 * each is one segment and none of them branch. A credential is
 * unconditional — an active scheme is always sent — so it needs no null
 * branch, and a query credential joins the same query bag a declared
 * parameter does. That is what keeps one `?` in the request target whether
 * or not the operation has query parameters of its own.
 *
 * Credential segments come last of their kind, after the declared
 * parameters, so request diffs stay predictable and auth reads as the
 * transport policy `no-inheritance-no-protected-regions` frames it as.
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
    public function headerSegments(array $activeSchemes, PhpNamespace $namespace): array
    {
        $segments = [];

        foreach ($activeSchemes as $scheme) {
            $segment = $this->headerSegment($scheme, $namespace);

            if ($segment !== '') {
                $segments[] = $segment;
            }
        }

        return $segments;
    }

    private function headerSegment(SecurityScheme $scheme, PhpNamespace $namespace): string
    {
        $name = var_export($scheme->wireName, true);

        return match ($scheme->kind) {
            SecurityScheme::KIND_API_KEY_HEADER => sprintf('->header(%s, $this->%s)', $name, $scheme->ctorArg),
            // A cookie credential is one `name=value` pair inside a `Cookie`
            // header; the declared key names the cookie, not the header.
            SecurityScheme::KIND_API_KEY_COOKIE => sprintf(
                '->header(%s, %s . $this->%s)',
                $name,
                var_export($scheme->schemeToken . '=', true),
                $scheme->ctorArg,
            ),
            SecurityScheme::KIND_BASIC => $this->basicSegment($scheme, $namespace),
            // RFC 7235: the credential follows the scheme token. `Bearer` for
            // http bearer and for an OAuth2 or OIDC access token (RFC 6750),
            // and the document's own word for anything else.
            SecurityScheme::KIND_BEARER,
            SecurityScheme::KIND_HTTP_SCHEME_TOKEN,
            SecurityScheme::KIND_OAUTH2,
            SecurityScheme::KIND_OPENID_CONNECT => sprintf(
                '->header(%s, %s . $this->%s)',
                $name,
                var_export($scheme->schemeToken . ' ', true),
                $scheme->ctorArg,
            ),
            default => '',
        };
    }

    /**
     * The one kind whose credential is two values. They meet as
     * `base64(user:password)` and nowhere else, so the joining belongs here
     * rather than in a consumer who would have to look up RFC 7617 to do it.
     */
    private function basicSegment(SecurityScheme $scheme, PhpNamespace $namespace): string
    {
        $namespace->addUseFunction('base64_encode');

        return sprintf(
            '->header(%s, %s . base64_encode($this->%s . %s . $this->%s))',
            var_export($scheme->wireName, true),
            var_export($scheme->schemeToken . ' ', true),
            $scheme->ctorArg,
            var_export(':', true),
            $scheme->secondaryCtorArg,
        );
    }
}
