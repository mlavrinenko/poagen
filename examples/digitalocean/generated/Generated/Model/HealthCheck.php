<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class HealthCheck implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'check_interval_seconds' => ['check_interval_seconds', null],
        'healthy_threshold' => ['healthy_threshold', null],
        'path' => ['path', null],
        'port' => ['port', null],
        'protocol' => ['protocol', null],
        'response_timeout_seconds' => ['response_timeout_seconds', null],
        'unhealthy_threshold' => ['unhealthy_threshold', null],
    ];

    public function __construct(
        public ?int $check_interval_seconds = null,
        public ?int $healthy_threshold = null,
        public ?string $path = null,
        public ?int $port = null,
        public ?string $protocol = null,
        public ?int $response_timeout_seconds = null,
        public ?int $unhealthy_threshold = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'check_interval_seconds' => $this->check_interval_seconds,
            'healthy_threshold' => $this->healthy_threshold,
            'path' => $this->path,
            'port' => $this->port,
            'protocol' => $this->protocol,
            'response_timeout_seconds' => $this->response_timeout_seconds,
            'unhealthy_threshold' => $this->unhealthy_threshold,
        ];
    }
}
