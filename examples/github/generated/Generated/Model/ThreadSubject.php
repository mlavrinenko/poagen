<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ThreadSubject implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'latest_comment_url' => ['latest_comment_url', null],
        'title' => ['title', null],
        'type' => ['type', null],
        'url' => ['url', null],
    ];

    public function __construct(
        public string $latest_comment_url,
        public string $title,
        public string $type,
        public string $url,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'latest_comment_url' => $this->latest_comment_url,
            'title' => $this->title,
            'type' => $this->type,
            'url' => $this->url,
        ];
    }
}
