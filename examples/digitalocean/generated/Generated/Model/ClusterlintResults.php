<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class ClusterlintResults implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'completed_at' => ['completed_at', ['datetime', null]],
        'diagnostics' => ['diagnostics', ['list', null]],
        'requested_at' => ['requested_at', ['datetime', null]],
        'run_id' => ['run_id', null],
    ];

    /**
     * @param ?list<array<string, mixed>> $diagnostics
     */
    public function __construct(
        public ?DateTimeImmutable $completed_at = null,
        public ?array $diagnostics = null,
        public ?DateTimeImmutable $requested_at = null,
        public ?string $run_id = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'completed_at' => $this->completed_at?->format(\DateTimeInterface::RFC3339),
            'diagnostics' => $this->diagnostics,
            'requested_at' => $this->requested_at?->format(\DateTimeInterface::RFC3339),
            'run_id' => $this->run_id,
        ];
    }
}
