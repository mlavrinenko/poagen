<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\OAuthFlow;
use cebe\openapi\spec\OAuthFlows;
use cebe\openapi\spec\SecurityScheme as CebeSecurityScheme;

use function is_string;

/**
 * The half of an `oauth2` or `openIdConnect` declaration that is not a
 * credential: which flows the vendor supports, the three URLs each flow
 * names, and the scopes it declares with the vendor's own descriptions.
 *
 * poagen sends an access token and nothing more — obtaining one is the
 * consumer's transport's job, per `operations-delegate-to-an-injected-transport`.
 * But the consumer still has to point `league/oauth2-client` (or whatever
 * they reach for) at a token endpoint and ask for the right scopes, and
 * today that means re-reading the vendor's YAML beside the typed client
 * poagen already gave them. Carrying the metadata across is the cheap half
 * of "emit everything the document says that helps a consumer wire their
 * own transport".
 *
 * @phpstan-type FlowSpec array{authorizationUrl: string|null, tokenUrl: string|null, refreshUrl: string|null, scopes: array<string, string>}
 *
 * @internal
 */
final readonly class SecurityFlows
{
    /**
     * The four flows OpenAPI 3 declares, in the order the specification
     * lists them, so emitted metadata orders by the document's grammar
     * rather than by hash iteration.
     */
    private const array FLOW_NAMES = ['implicit', 'password', 'clientCredentials', 'authorizationCode'];

    /**
     * @param array<string, FlowSpec> $flows           keyed by flow name; empty for `openIdConnect`,
     *                                                 which points at a discovery document instead
     * @param string|null             $discoveryUrl    `openIdConnectUrl`, the one metadata field an
     *                                                 `openIdConnect` declaration carries
     */
    public function __construct(
        public array $flows,
        public ?string $discoveryUrl = null,
    ) {}

    public static function fromCebe(CebeSecurityScheme $scheme): self
    {
        $flows = $scheme->flows ?? null;
        $discovery = $scheme->openIdConnectUrl ?? null;

        return new self(
            $flows instanceof OAuthFlows ? self::readFlows($flows) : [],
            is_string($discovery) && $discovery !== '' ? $discovery : null,
        );
    }

    public function isEmpty(): bool
    {
        return $this->flows === [] && $this->discoveryUrl === null;
    }

    /**
     * @return array<string, FlowSpec>
     */
    private static function readFlows(OAuthFlows $flows): array
    {
        $out = [];

        foreach (self::FLOW_NAMES as $name) {
            $flow = $flows->{$name} ?? null;

            if ($flow instanceof OAuthFlow) {
                $out[$name] = self::readFlow($flow);
            }
        }

        return $out;
    }

    /**
     * @return FlowSpec
     */
    private static function readFlow(OAuthFlow $flow): array
    {
        /** @var array<string, string> $scopes */
        $scopes = $flow->scopes ?? [];

        return [
            'authorizationUrl' => self::url($flow->authorizationUrl ?? null),
            'tokenUrl' => self::url($flow->tokenUrl ?? null),
            'refreshUrl' => self::url($flow->refreshUrl ?? null),
            'scopes' => $scopes,
        ];
    }

    private static function url(mixed $value): ?string
    {
        return is_string($value) && $value !== '' ? $value : null;
    }
}
