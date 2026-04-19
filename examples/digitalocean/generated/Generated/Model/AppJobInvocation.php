<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class AppJobInvocation implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'completed_at' => ['completed_at', ['datetime', null]],
        'created_at' => ['created_at', ['datetime', null]],
        'deployment_id' => ['deployment_id', null],
        'id' => ['id', null],
        'job_name' => ['job_name', null],
        'phase' => ['phase', null],
        'started_at' => ['started_at', ['datetime', null]],
        'trigger' => ['trigger', \Acme\DigitalOcean\Generated\Model\AppJobInvocationTrigger::class],
    ];

    public function __construct(
        public ?DateTimeImmutable $completed_at = null,
        public ?DateTimeImmutable $created_at = null,
        public ?string $deployment_id = null,
        public ?string $id = null,
        public ?string $job_name = null,
        public ?string $phase = null,
        public ?DateTimeImmutable $started_at = null,
        public ?AppJobInvocationTrigger $trigger = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'completed_at' => $this->completed_at?->format(\DateTimeInterface::RFC3339),
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'deployment_id' => $this->deployment_id,
            'id' => $this->id,
            'job_name' => $this->job_name,
            'phase' => $this->phase,
            'started_at' => $this->started_at?->format(\DateTimeInterface::RFC3339),
            'trigger' => $this->trigger,
        ];
    }
}
