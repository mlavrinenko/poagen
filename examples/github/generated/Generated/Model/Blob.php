<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class Blob implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'content' => ['content', null],
        'encoding' => ['encoding', null],
        'node_id' => ['node_id', null],
        'sha' => ['sha', null],
        'size' => ['size', null],
        'url' => ['url', null],
        'highlighted_content' => ['highlighted_content', null],
    ];

    public function __construct(
        public string $content,
        public string $encoding,
        public string $node_id,
        public string $sha,
        public ?int $size = null,
        public string $url,
        public ?string $highlighted_content = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'content' => $this->content,
            'encoding' => $this->encoding,
            'node_id' => $this->node_id,
            'sha' => $this->sha,
            'size' => $this->size,
            'url' => $this->url,
            'highlighted_content' => $this->highlighted_content,
        ];
    }
}
