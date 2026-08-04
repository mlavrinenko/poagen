<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\SecurityScheme as CebeSecurityScheme;

use function sprintf;

/**
 * Sorts one declared `securityScheme` into a {@see SecurityScheme}.
 *
 * Split out of the value it produces because the rules are the interesting
 * part and they are read far more often than the fields: which `in` values
 * an `apiKey` may take, which `http` scheme tokens can be sent without a
 * handshake, and where the line falls between "poagen does not know this"
 * and "poagen refuses this".
 *
 * The `http` fallback is the deliberate default the owner ruling calls the
 * "sane default that works in almost every case": RFC 7235 puts a
 * credential after the scheme token, so a vendor word poagen has never
 * seen still reaches the wire correctly as
 * `Authorization: <SchemeToken> <credential>`. Only the two schemes that
 * genuinely cannot work that way — `digest` and `negotiate`, which need a
 * challenge and a second request before any credential exists — are
 * refused, along with any scheme `type` the specification does not define.
 *
 * @internal
 */
final readonly class SecuritySchemeClassifier
{
    /**
     * RFC 7230 `token` characters. An `http` scheme token outside this set
     * cannot be put in an `Authorization` header at all, so it is refused
     * rather than emitted into a request that would be rejected or, worse,
     * split.
     */
    private const string TOKEN = '/^[A-Za-z0-9!#$%&\'*+.^_`|~-]+$/';

    public static function classify(string $name, CebeSecurityScheme $scheme): SecurityScheme
    {
        $type = (string) ($scheme->type ?? '');

        return match ($type) {
            'apiKey' => self::apiKey($name, $scheme),
            'http' => self::http($name, $scheme),
            'oauth2' => self::token($name, SecurityScheme::KIND_OAUTH2, $scheme),
            'openIdConnect' => self::token($name, SecurityScheme::KIND_OPENID_CONNECT, $scheme),
            'mutualTLS' => new SecurityScheme(
                kind: SecurityScheme::KIND_MUTUAL_TLS,
                wireName: '',
                ctorArg: '',
                name: $name,
                typeLabel: 'mutualTLS',
            ),
            default => self::refuse(
                $name,
                $type === '' ? '(no type)' : $type,
                'poagen does not recognise this scheme type; unknown means refused, never ignored',
            ),
        };
    }

    private static function apiKey(string $name, CebeSecurityScheme $scheme): SecurityScheme
    {
        $in = (string) ($scheme->in ?? '');
        $wireName = (string) ($scheme->name ?? '');
        $kind = match ($in) {
            'header' => SecurityScheme::KIND_API_KEY_HEADER,
            'query' => SecurityScheme::KIND_API_KEY_QUERY,
            'cookie' => SecurityScheme::KIND_API_KEY_COOKIE,
            default => null,
        };

        if ($kind === null) {
            return self::refuse(
                $name,
                sprintf("apiKey in: '%s'", $in),
                'an apiKey scheme is sent in a header, a query parameter or a cookie; nothing else is a place poagen can put it',
            );
        }

        if ($wireName === '') {
            return self::refuse(
                $name,
                sprintf('apiKey in: %s', $in),
                'the declaration carries no `name`, so there is no key to send the credential under',
            );
        }

        return new SecurityScheme(
            kind: $kind,
            wireName: $kind === SecurityScheme::KIND_API_KEY_COOKIE ? 'Cookie' : $wireName,
            ctorArg: SecurityScheme::camelize($name),
            name: $name,
            // A cookie credential travels inside a `Cookie` header as
            // `name=value`, so the declared key is the cookie's name rather
            // than the header's and has to survive separately.
            schemeToken: $kind === SecurityScheme::KIND_API_KEY_COOKIE ? $wireName : '',
            typeLabel: sprintf('apiKey in: %s', $in),
        );
    }

    private static function http(string $name, CebeSecurityScheme $scheme): SecurityScheme
    {
        $raw = (string) ($scheme->scheme ?? '');
        $lower = strtolower($raw);

        if ($lower === 'bearer') {
            return new SecurityScheme(
                kind: SecurityScheme::KIND_BEARER,
                wireName: 'Authorization',
                ctorArg: 'bearerToken',
                name: $name,
                schemeToken: 'Bearer',
                typeLabel: 'http bearer',
            );
        }

        if ($lower === 'basic') {
            return new SecurityScheme(
                kind: SecurityScheme::KIND_BASIC,
                wireName: 'Authorization',
                ctorArg: 'basicUser',
                name: $name,
                secondaryCtorArg: 'basicPassword',
                schemeToken: 'Basic',
                typeLabel: 'http basic',
            );
        }

        if ($lower === 'digest' || $lower === 'negotiate') {
            return self::refuse(
                $name,
                'http ' . $lower,
                'the credential only exists after the server\'s challenge and a second request, and poagen will not '
                    . 'run a protocol',
            );
        }

        if ($raw === '' || preg_match(self::TOKEN, $raw) !== 1) {
            return self::refuse(
                $name,
                $raw === '' ? 'http (no scheme)' : sprintf("http '%s'", $raw),
                'an http scheme name has to be a token that can precede a credential in an Authorization header',
            );
        }

        return new SecurityScheme(
            kind: SecurityScheme::KIND_HTTP_SCHEME_TOKEN,
            wireName: 'Authorization',
            ctorArg: SecurityScheme::camelize($name),
            name: $name,
            schemeToken: $raw,
            typeLabel: sprintf('http %s', $raw),
        );
    }

    /**
     * `oauth2` and `openIdConnect` are the same thing at the wire — one
     * access token in an `Authorization: Bearer` header, which is what RFC
     * 6750 says an OAuth2 access token looks like for every one of the four
     * flows. They differ only in the metadata they carry alongside it.
     */
    private static function token(string $name, string $kind, CebeSecurityScheme $scheme): SecurityScheme
    {
        return new SecurityScheme(
            kind: $kind,
            wireName: 'Authorization',
            ctorArg: SecurityScheme::camelize($name),
            name: $name,
            schemeToken: 'Bearer',
            typeLabel: $kind === SecurityScheme::KIND_OAUTH2 ? 'oauth2' : 'openIdConnect',
            flows: SecurityFlows::fromCebe($scheme),
        );
    }

    private static function refuse(string $name, string $typeLabel, string $reason): SecurityScheme
    {
        return new SecurityScheme(
            kind: SecurityScheme::KIND_REFUSED,
            wireName: '',
            ctorArg: '',
            name: $name,
            typeLabel: $typeLabel,
            refusalReason: $reason,
        );
    }
}
