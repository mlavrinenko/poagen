<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class ProjectsV2IterationSettings implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'completed' => ['completed', null],
        'duration' => ['duration', null],
        'id' => ['id', null],
        'start_date' => ['start_date', ['date', null]],
        'title' => ['title', \Acme\GitHub\Generated\Model\ProjectsV2IterationSettingsTitle::class],
    ];

    public function __construct(
        public bool $completed,
        public int $duration,
        public string $id,
        public DateTimeImmutable $start_date,
        public ProjectsV2IterationSettingsTitle $title,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'completed' => $this->completed,
            'duration' => $this->duration,
            'id' => $this->id,
            'start_date' => $this->start_date->format('Y-m-d'),
            'title' => $this->title,
        ];
    }
}
