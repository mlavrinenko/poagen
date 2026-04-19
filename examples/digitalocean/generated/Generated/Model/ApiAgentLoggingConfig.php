<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class ApiAgentLoggingConfig implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'galileo_project_id' => ['galileo_project_id', null],
        'galileo_project_name' => ['galileo_project_name', null],
        'insights_enabled' => ['insights_enabled', null],
        'insights_enabled_at' => ['insights_enabled_at', ['datetime', null]],
        'log_stream_id' => ['log_stream_id', null],
        'log_stream_name' => ['log_stream_name', null],
    ];

    public function __construct(
        public ?string $galileo_project_id = null,
        public ?string $galileo_project_name = null,
        public ?bool $insights_enabled = null,
        public ?DateTimeImmutable $insights_enabled_at = null,
        public ?string $log_stream_id = null,
        public ?string $log_stream_name = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'galileo_project_id' => $this->galileo_project_id,
            'galileo_project_name' => $this->galileo_project_name,
            'insights_enabled' => $this->insights_enabled,
            'insights_enabled_at' => $this->insights_enabled_at?->format(\DateTimeInterface::RFC3339),
            'log_stream_id' => $this->log_stream_id,
            'log_stream_name' => $this->log_stream_name,
        ];
    }
}
