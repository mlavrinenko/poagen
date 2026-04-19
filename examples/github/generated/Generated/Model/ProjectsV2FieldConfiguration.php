<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ProjectsV2FieldConfiguration implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'duration' => ['duration', null],
        'iterations' => ['iterations', ['list', \Acme\GitHub\Generated\Model\ProjectsV2IterationSettings::class]],
        'start_day' => ['start_day', null],
    ];

    /**
     * @param ?list<\Acme\GitHub\Generated\Model\ProjectsV2IterationSettings> $iterations
     */
    public function __construct(
        public ?int $duration = null,
        public ?array $iterations = null,
        public ?int $start_day = null,
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
            'start_day' => $this->start_day,
        ];
    }
}
