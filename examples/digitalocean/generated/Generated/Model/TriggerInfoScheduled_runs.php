<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class TriggerInfoScheduled_runs implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['last_run_at' => ['last_run_at', null], 'next_run_at' => ['next_run_at', null]];

    public function __construct(
        public ?string $last_run_at = null,
        public ?string $next_run_at = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'last_run_at' => $this->last_run_at,
            'next_run_at' => $this->next_run_at,
        ];
    }
}
