<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppServiceSpecTermination implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'drain_seconds' => ['drain_seconds', null],
        'grace_period_seconds' => ['grace_period_seconds', null],
    ];

    public function __construct(
        public ?int $drain_seconds = null,
        public ?int $grace_period_seconds = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'drain_seconds' => $this->drain_seconds,
            'grace_period_seconds' => $this->grace_period_seconds,
        ];
    }
}
