<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\AppAlertProgressStepStatus;
use DateTimeImmutable;
use JsonSerializable;

final readonly class AppAlertProgressStep implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'ended_at' => ['ended_at', ['datetime', null]],
        'name' => ['name', null],
        'reason' => ['reason', \Acme\DigitalOcean\Generated\Model\AppAlertProgressStepReason::class],
        'started_at' => ['started_at', ['datetime', null]],
        'status' => ['status', ['enum', \Acme\DigitalOcean\Generated\Enum\AppAlertProgressStepStatus::class]],
    ];

    public function __construct(
        public ?DateTimeImmutable $ended_at = null,
        public ?string $name = null,
        public ?AppAlertProgressStepReason $reason = null,
        public ?DateTimeImmutable $started_at = null,
        public ?AppAlertProgressStepStatus $status = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'ended_at' => $this->ended_at?->format(\DateTimeInterface::RFC3339),
            'name' => $this->name,
            'reason' => $this->reason,
            'started_at' => $this->started_at?->format(\DateTimeInterface::RFC3339),
            'status' => $this->status,
        ];
    }
}
