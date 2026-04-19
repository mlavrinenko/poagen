<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class LabelSearchResultItem implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'color' => ['color', null],
        'default' => ['default', null],
        'description' => ['description', null],
        'id' => ['id', null],
        'name' => ['name', null],
        'node_id' => ['node_id', null],
        'score' => ['score', null],
        'url' => ['url', null],
        'text_matches' => ['text_matches', \Acme\GitHub\Generated\Model\SearchResultTextMatches::class],
    ];

    public function __construct(
        public string $color,
        public bool $default,
        public ?string $description = null,
        public int $id,
        public string $name,
        public string $node_id,
        public float $score,
        public string $url,
        public ?SearchResultTextMatches $text_matches = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'color' => $this->color,
            'default' => $this->default,
            'description' => $this->description,
            'id' => $this->id,
            'name' => $this->name,
            'node_id' => $this->node_id,
            'score' => $this->score,
            'url' => $this->url,
            'text_matches' => $this->text_matches,
        ];
    }
}
