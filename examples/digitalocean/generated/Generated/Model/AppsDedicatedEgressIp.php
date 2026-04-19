<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\AppsDedicatedEgressIpStatus;
use JsonSerializable;

final readonly class AppsDedicatedEgressIp implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'id' => ['id', null],
        'ip' => ['ip', null],
        'status' => ['status', ['enum', \Acme\DigitalOcean\Generated\Enum\AppsDedicatedEgressIpStatus::class]],
    ];

    public function __construct(
        public ?string $id = null,
        public ?string $ip = null,
        public ?AppsDedicatedEgressIpStatus $status = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'ip' => $this->ip,
            'status' => $this->status,
        ];
    }
}
