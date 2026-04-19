<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\SecurityScheme as CebeSecurityScheme;

/**
 * Classifies one OpenAPI `securityScheme` into the subset the generator
 * actually wires up today: `apiKey` with `in: header` and `http bearer`.
 *
 * Everything else — `apiKey` in cookie/query, `http basic`, `oauth2`,
 * `openIdConnect` — is flagged {@see self::KIND_UNSUPPORTED} and left
 * to the decorator-layer runtime per ADR-002. Treating unsupported
 * schemes as first-class values (rather than null) keeps the catalog's
 * caller code uniform: it iterates over every named scheme and skips
 * unsupported ones at the emission site instead of the collection site.
 *
 * @internal
 */
final readonly class SecurityScheme
{
    public const string KIND_API_KEY_HEADER = 'api_key_header';
    public const string KIND_BEARER = 'bearer';
    public const string KIND_UNSUPPORTED = 'unsupported';

    public function __construct(
        public string $kind,
        public string $headerName,
        public string $ctorArg,
    ) {}

    /**
     * Normalise a cebe SecurityScheme into our VO.
     *
     * `$name` is the key under `components.securitySchemes`; it drives the
     * PHP-safe constructor argument name for apiKey schemes. Bearer schemes
     * always use the fixed arg name `bearerToken` since there is one
     * Authorization header per request — differentiating on the scheme's
     * user-supplied key would generate confusing constructor signatures
     * when two schemas happen to share the same JWT mechanic.
     */
    public static function fromCebe(string $name, CebeSecurityScheme $scheme): self
    {
        $type = (string) ($scheme->type ?? '');

        if ($type === 'apiKey') {
            $in = (string) ($scheme->in ?? '');
            $headerName = (string) ($scheme->name ?? '');

            if ($in === 'header' && $headerName !== '') {
                return new self(
                    kind: self::KIND_API_KEY_HEADER,
                    headerName: $headerName,
                    ctorArg: self::camelize($name),
                );
            }
        }

        if ($type === 'http') {
            $httpScheme = (string) ($scheme->scheme ?? '');

            if ($httpScheme === 'bearer') {
                return new self(
                    kind: self::KIND_BEARER,
                    headerName: 'Authorization',
                    ctorArg: 'bearerToken',
                );
            }
        }

        return new self(
            kind: self::KIND_UNSUPPORTED,
            headerName: '',
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
     */
    private static function camelize(string $name): string
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
