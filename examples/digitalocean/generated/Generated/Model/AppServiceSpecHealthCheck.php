<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppServiceSpecHealthCheck implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'failure_threshold' => ['failure_threshold', null],
        'http_path' => ['http_path', null],
        'initial_delay_seconds' => ['initial_delay_seconds', null],
        'period_seconds' => ['period_seconds', null],
        'port' => ['port', null],
        'success_threshold' => ['success_threshold', null],
        'timeout_seconds' => ['timeout_seconds', null],
    ];

    public function __construct(
        public ?int $failure_threshold = null,
        public ?string $http_path = null,
        public ?int $initial_delay_seconds = null,
        public ?int $period_seconds = null,
        public ?int $port = null,
        public ?int $success_threshold = null,
        public ?int $timeout_seconds = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'failure_threshold' => $this->failure_threshold,
            'http_path' => $this->http_path,
            'initial_delay_seconds' => $this->initial_delay_seconds,
            'period_seconds' => $this->period_seconds,
            'port' => $this->port,
            'success_threshold' => $this->success_threshold,
            'timeout_seconds' => $this->timeout_seconds,
        ];
    }
}
