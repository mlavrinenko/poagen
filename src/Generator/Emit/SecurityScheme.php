<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\SecurityScheme as CebeSecurityScheme;

/**
 * Classifies one OpenAPI `securityScheme` into the subset the generator
 * actually wires up today: `apiKey` with `in: header`, `apiKey` with
 * `in: query`, and `http bearer`.
 *
 * Everything else — `apiKey` in cookie, `http basic`, `oauth2`,
 * `openIdConnect` — is flagged {@see self::KIND_UNSUPPORTED} and left
 * to the decorator-layer runtime per
 * `operations-delegate-to-an-injected-transport`. Treating unsupported
 * schemes as first-class values (rather than null) keeps the catalog's
 * caller code uniform: it iterates over every named scheme and skips
 * unsupported ones at the emission site instead of the collection site.
 *
 * @internal
 */
final readonly class SecurityScheme
{
    public const string KIND_API_KEY_HEADER = 'api_key_header';
    public const string KIND_API_KEY_QUERY = 'api_key_query';
    public const string KIND_BEARER = 'bearer';
    public const string KIND_UNSUPPORTED = 'unsupported';

    /**
     * `$wireName` is the key this credential travels under on the wire: a
     * header name for the header/bearer kinds, a query parameter name for
     * the query kind. Deliberately not `headerName` — a query-string
     * credential has no header at all.
     */
    public function __construct(
        public string $kind,
        public string $wireName,
        public string $ctorArg,
    ) {}

    /**
     * Normalise a cebe SecurityScheme into our VO.
     *
     * `$name` is the key under `components.securitySchemes`; it drives the
     * PHP-safe constructor argument name for apiKey schemes. Bearer schemes
     * propose the fixed arg name `bearerToken` since there is usually one
     * Authorization header per request and one credential behind it. That
     * proposal is not final: {@see SecuritySchemeCatalog} sees every scheme
     * in the document at once and falls back to a name-derived ctorArg (via
     * {@see self::camelize()}) whenever two schemes — bearer or otherwise —
     * would otherwise collide. See
     * `truth/decisions/distinct-ctor-args-for-colliding-schemes.decision-260802.typ`.
     */
    public static function fromCebe(string $name, CebeSecurityScheme $scheme): self
    {
        $type = (string) ($scheme->type ?? '');

        if ($type === 'apiKey') {
            $in = (string) ($scheme->in ?? '');
            $wireName = (string) ($scheme->name ?? '');

            if ($in === 'header' && $wireName !== '') {
                return new self(
                    kind: self::KIND_API_KEY_HEADER,
                    wireName: $wireName,
                    ctorArg: self::camelize($name),
                );
            }

            if ($in === 'query' && $wireName !== '') {
                return new self(
                    kind: self::KIND_API_KEY_QUERY,
                    wireName: $wireName,
                    ctorArg: self::camelize($name),
                );
            }
        }

        if ($type === 'http') {
            $httpScheme = (string) ($scheme->scheme ?? '');

            if ($httpScheme === 'bearer') {
                return new self(
                    kind: self::KIND_BEARER,
                    wireName: 'Authorization',
                    ctorArg: 'bearerToken',
                );
            }
        }

        return new self(
            kind: self::KIND_UNSUPPORTED,
            wireName: '',
            ctorArg: '',
        );
    }

    public function isSupported(): bool
    {
        return $this->kind !== self::KIND_UNSUPPORTED;
    }

    /**
     * Turn a scheme key like `apiKey_scheme` or `api-key` into a PHP-safe
     * camelCase identifier. Leading non-letters are dropped; otherwise
     * preserves existing camelCase segments.
     *
     * Public because {@see SecuritySchemeCatalog} reuses it to derive a
     * collision-breaking ctorArg for schemes whose kind-default name isn't
     * unique in the document.
     */
    public static function camelize(string $name): string
    {
        $split = preg_split('/[^A-Za-z0-9]+/', $name);
        $parts = $split === false ? [] : $split;
        $out = '';

        foreach ($parts as $i => $part) {
            if ($part === '') {
                continue;
            }
            $out .= $i === 0 ? lcfirst($part) : ucfirst($part);
        }

        if ($out === '' || preg_match('/^[A-Za-z_]/', $out) !== 1) {
            return '_' . $out;
        }

        return $out;
    }
}
