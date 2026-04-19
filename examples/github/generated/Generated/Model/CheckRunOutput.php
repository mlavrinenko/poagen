<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CheckRunOutput implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'annotations_count' => ['annotations_count', null],
        'annotations_url' => ['annotations_url', null],
        'summary' => ['summary', null],
        'text' => ['text', null],
        'title' => ['title', null],
    ];

    public function __construct(
        public int $annotations_count,
        public string $annotations_url,
        public ?string $summary = null,
        public ?string $text = null,
        public ?string $title = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'annotations_count' => $this->annotations_count,
            'annotations_url' => $this->annotations_url,
            'summary' => $this->summary,
            'text' => $this->text,
            'title' => $this->title,
        ];
    }
}
