<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class DedicatedInferenceEndpoints implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'private_endpoint_fqdn' => ['private_endpoint_fqdn', null],
        'public_endpoint_fqdn' => ['public_endpoint_fqdn', null],
    ];

    public function __construct(
        public ?string $private_endpoint_fqdn = null,
        public ?string $public_endpoint_fqdn = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'private_endpoint_fqdn' => $this->private_endpoint_fqdn,
            'public_endpoint_fqdn' => $this->public_endpoint_fqdn,
        ];
    }
}
