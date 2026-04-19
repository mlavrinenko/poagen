<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CodespacesPublicKey implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'key' => ['key', null],
        'key_id' => ['key_id', null],
        'created_at' => ['created_at', null],
        'id' => ['id', null],
        'title' => ['title', null],
        'url' => ['url', null],
    ];

    public function __construct(
        public string $key,
        public string $key_id,
        public ?string $created_at = null,
        public ?int $id = null,
        public ?string $title = null,
        public ?string $url = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'key' => $this->key,
            'key_id' => $this->key_id,
            'created_at' => $this->created_at,
            'id' => $this->id,
            'title' => $this->title,
            'url' => $this->url,
        ];
    }
}
