<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class PendingDeployment implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'current_user_can_approve' => ['current_user_can_approve', null],
        'environment' => ['environment', \Acme\GitHub\Generated\Model\PendingDeploymentEnvironment::class],
        'reviewers' => ['reviewers', ['list', null]],
        'wait_timer' => ['wait_timer', null],
        'wait_timer_started_at' => ['wait_timer_started_at', ['datetime', null]],
    ];

    /**
     * @param list<array<string, mixed>> $reviewers
     */
    public function __construct(
        public bool $current_user_can_approve,
        public PendingDeploymentEnvironment $environment,
        public array $reviewers,
        public int $wait_timer,
        public ?DateTimeImmutable $wait_timer_started_at = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'current_user_can_approve' => $this->current_user_can_approve,
            'environment' => $this->environment,
            'reviewers' => $this->reviewers,
            'wait_timer' => $this->wait_timer,
            'wait_timer_started_at' => $this->wait_timer_started_at?->format(\DateTimeInterface::RFC3339),
        ];
    }
}
