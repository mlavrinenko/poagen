<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppLogDestinationDatadogSpec implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['api_key' => ['api_key', null], 'endpoint' => ['endpoint', null]];

    public function __construct(
        public string $api_key,
        public ?string $endpoint = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'api_key' => $this->api_key,
            'endpoint' => $this->endpoint,
        ];
    }
}
