<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppLogDestinationOpenSearchSpec implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'basic_auth' => ['basic_auth', \Acme\DigitalOcean\Generated\Model\AppLogDestinationOpenSearchSpecBasicAuth::class],
        'cluster_name' => ['cluster_name', null],
        'endpoint' => ['endpoint', null],
        'index_name' => ['index_name', null],
    ];

    public function __construct(
        public ?AppLogDestinationOpenSearchSpecBasicAuth $basic_auth = null,
        public ?string $cluster_name = null,
        public ?string $endpoint = null,
        public ?string $index_name = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'basic_auth' => $this->basic_auth,
            'cluster_name' => $this->cluster_name,
            'endpoint' => $this->endpoint,
            'index_name' => $this->index_name,
        ];
    }
}
