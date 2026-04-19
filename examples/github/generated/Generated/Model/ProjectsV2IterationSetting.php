<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ProjectsV2IterationSetting implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'id' => ['id', null],
        'title' => ['title', null],
        'completed' => ['completed', null],
        'duration' => ['duration', null],
        'start_date' => ['start_date', null],
        'title_html' => ['title_html', null],
    ];

    public function __construct(
        public string $id,
        public string $title,
        public ?bool $completed = null,
        public ?float $duration = null,
        public ?string $start_date = null,
        public ?string $title_html = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'completed' => $this->completed,
            'duration' => $this->duration,
            'start_date' => $this->start_date,
            'title_html' => $this->title_html,
        ];
    }
}
