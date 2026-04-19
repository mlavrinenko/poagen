<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class ProjectsV2FieldIterationConfiguration implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'duration' => ['duration', null],
        'iterations' => ['iterations', ['list', null]],
        'start_date' => ['start_date', ['date', null]],
    ];

    /**
     * @param ?list<array<string, mixed>> $iterations
     */
    public function __construct(
        public ?int $duration = null,
        public ?array $iterations = null,
        public ?DateTimeImmutable $start_date = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'duration' => $this->duration,
            'iterations' => $this->iterations,
            'start_date' => $this->start_date?->format('Y-m-d'),
        ];
    }
}
