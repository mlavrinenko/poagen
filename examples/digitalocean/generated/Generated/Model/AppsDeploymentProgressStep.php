<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\AppsDeploymentProgressStepStatus;
use DateTimeImmutable;
use JsonSerializable;

final readonly class AppsDeploymentProgressStep implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'component_name' => ['component_name', null],
        'ended_at' => ['ended_at', ['datetime', null]],
        'message_base' => ['message_base', null],
        'name' => ['name', null],
        'reason' => ['reason', \Acme\DigitalOcean\Generated\Model\AppsDeploymentProgressStepReason::class],
        'started_at' => ['started_at', ['datetime', null]],
        'status' => ['status', ['enum', \Acme\DigitalOcean\Generated\Enum\AppsDeploymentProgressStepStatus::class]],
        'steps' => ['steps', ['list', null]],
    ];

    /**
     * @param ?list<array<string, mixed>> $steps
     */
    public function __construct(
        public ?string $component_name = null,
        public ?DateTimeImmutable $ended_at = null,
        public ?string $message_base = null,
        public ?string $name = null,
        public ?AppsDeploymentProgressStepReason $reason = null,
        public ?DateTimeImmutable $started_at = null,
        public ?AppsDeploymentProgressStepStatus $status = null,
        public ?array $steps = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'component_name' => $this->component_name,
            'ended_at' => $this->ended_at?->format(\DateTimeInterface::RFC3339),
            'message_base' => $this->message_base,
            'name' => $this->name,
            'reason' => $this->reason,
            'started_at' => $this->started_at?->format(\DateTimeInterface::RFC3339),
            'status' => $this->status,
            'steps' => $this->steps,
        ];
    }
}
