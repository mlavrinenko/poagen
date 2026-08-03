<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use function in_array;

/**
 * One classified OpenAPI `securityScheme`, sorted into the three reactions
 * paogen has to a scheme: wire it, report it, or refuse it by name.
 *
 * Almost everything is wired, because almost every scheme in OpenAPI
 * reduces to one credential attached to one place on one request — an
 * `apiKey` in a header, a query key or a cookie, an `Authorization` header
 * carrying a scheme token and a credential after it, an OAuth2 access
 * token, which RFC 6750 says is a bearer credential for all four flows.
 * paogen never acquires, refreshes, stores or validates any of them: it
 * emits the constructor argument and puts the value on the request, and
 * everything before that is the consumer's transport
 * (`operations-delegate-to-an-injected-transport`).
 *
 * `mutualTLS` is reported rather than wired — the material lives in the TLS
 * handshake on the consumer's PSR-18 client, so there is no request-level
 * credential to emit and nothing shrank by saying so.
 *
 * `http digest`, `http negotiate` and anything unrecognised are refused,
 * because a credential only exists after a challenge and a second request,
 * and paogen will not run a protocol. Unknown means refused, never ignored
 * (`fail-loud-never-silent`).
 *
 * {@see SecuritySchemeClassifier} builds these; this file is the value.
 *
 * @internal
 */
final readonly class SecurityScheme
{
    public const string KIND_API_KEY_HEADER = 'api_key_header';
    public const string KIND_API_KEY_QUERY = 'api_key_query';
    public const string KIND_API_KEY_COOKIE = 'api_key_cookie';
    public const string KIND_BASIC = 'http_basic';
    public const string KIND_BEARER = 'bearer';
    public const string KIND_HTTP_SCHEME_TOKEN = 'http_scheme_token';
    public const string KIND_OAUTH2 = 'oauth2';
    public const string KIND_OPENID_CONNECT = 'openid_connect';
    public const string KIND_MUTUAL_TLS = 'mutual_tls';
    public const string KIND_REFUSED = 'refused';

    private const array WIRED = [
        self::KIND_API_KEY_HEADER,
        self::KIND_API_KEY_QUERY,
        self::KIND_API_KEY_COOKIE,
        self::KIND_BASIC,
        self::KIND_BEARER,
        self::KIND_HTTP_SCHEME_TOKEN,
        self::KIND_OAUTH2,
        self::KIND_OPENID_CONNECT,
    ];

    /**
     * `$wireName` is the key this credential travels under on the wire: a
     * header name for the header/cookie/`Authorization` kinds, a query
     * parameter name for the query kind. Deliberately not `headerName` — a
     * query-string credential has no header at all.
     *
     * `$secondaryCtorArg` is non-empty only for `http basic`, the one kind
     * whose credential is two values rather than one: a user and a password
     * that meet as `base64(user:password)` and nowhere else, so collapsing
     * them into one argument would make the consumer do the joining.
     *
     * `$schemeToken` is the `http` scheme name exactly as the document
     * spells it, for the kinds that put it before the credential.
     * `$typeLabel` and `$refusalReason` carry the diagnostic a refused
     * scheme aborts with.
     */
    public function __construct(
        public string $kind,
        public string $wireName,
        public string $ctorArg,
        public string $name = '',
        public string $secondaryCtorArg = '',
        public string $schemeToken = '',
        public string $typeLabel = '',
        public string $refusalReason = '',
        public ?SecurityFlows $flows = null,
    ) {}

    /** A credential paogen emits an argument for and puts on the request. */
    public function isWired(): bool
    {
        return in_array($this->kind, self::WIRED, true);
    }

    /** Declared, understood, and carrying nothing paogen can put on a request. */
    public function isReported(): bool
    {
        return $this->kind === self::KIND_MUTUAL_TLS;
    }

    public function isRefused(): bool
    {
        return $this->kind === self::KIND_REFUSED;
    }

    /** Whether the client should publish this scheme's own metadata. */
    public function hasFlowMetadata(): bool
    {
        return $this->flows instanceof SecurityFlows && !$this->flows->isEmpty();
    }

    /**
     * Every constructor argument this one scheme claims, in signature order.
     *
     * @return list<string>
     */
    public function ctorArgs(): array
    {
        return $this->secondaryCtorArg === ''
            ? [$this->ctorArg]
            : [$this->ctorArg, $this->secondaryCtorArg];
    }

    /**
     * The same scheme with its constructor argument(s) rebuilt from a
     * different base name — how {@see SecuritySchemeCatalog} breaks a tie
     * between two schemes of a kind whose default argument name is fixed.
     * A two-value kind derives both names from the one base, so the pair
     * stays recognisably one credential.
     */
    public function withCtorArgBase(string $base): self
    {
        $twoValued = $this->secondaryCtorArg !== '';

        return new self(
            kind: $this->kind,
            wireName: $this->wireName,
            ctorArg: $twoValued ? $base . 'User' : $base,
            name: $this->name,
            secondaryCtorArg: $twoValued ? $base . 'Password' : '',
            schemeToken: $this->schemeToken,
            typeLabel: $this->typeLabel,
            refusalReason: $this->refusalReason,
            flows: $this->flows,
        );
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
