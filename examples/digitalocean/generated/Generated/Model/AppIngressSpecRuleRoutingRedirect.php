<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppIngressSpecRuleRoutingRedirect implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'authority' => ['authority', null],
        'port' => ['port', null],
        'redirect_code' => ['redirect_code', null],
        'scheme' => ['scheme', null],
        'uri' => ['uri', null],
    ];

    public function __construct(
        public ?string $authority = null,
        public ?int $port = null,
        public ?int $redirect_code = null,
        public ?string $scheme = null,
        public ?string $uri = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'authority' => $this->authority,
            'port' => $this->port,
            'redirect_code' => $this->redirect_code,
            'scheme' => $this->scheme,
            'uri' => $this->uri,
        ];
    }
}
