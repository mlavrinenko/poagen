<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class License implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'body' => ['body', null],
        'conditions' => ['conditions', ['list', null]],
        'description' => ['description', null],
        'featured' => ['featured', null],
        'html_url' => ['html_url', null],
        'implementation' => ['implementation', null],
        'key' => ['key', null],
        'limitations' => ['limitations', ['list', null]],
        'name' => ['name', null],
        'node_id' => ['node_id', null],
        'permissions' => ['permissions', ['list', null]],
        'spdx_id' => ['spdx_id', null],
        'url' => ['url', null],
    ];

    /**
     * @param list<string> $conditions
     * @param list<string> $limitations
     * @param list<string> $permissions
     */
    public function __construct(
        public string $body,
        public array $conditions,
        public string $description,
        public bool $featured,
        public string $html_url,
        public string $implementation,
        public string $key,
        public array $limitations,
        public string $name,
        public string $node_id,
        public array $permissions,
        public ?string $spdx_id = null,
        public ?string $url = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'body' => $this->body,
            'conditions' => $this->conditions,
            'description' => $this->description,
            'featured' => $this->featured,
            'html_url' => $this->html_url,
            'implementation' => $this->implementation,
            'key' => $this->key,
            'limitations' => $this->limitations,
            'name' => $this->name,
            'node_id' => $this->node_id,
            'permissions' => $this->permissions,
            'spdx_id' => $this->spdx_id,
            'url' => $this->url,
        ];
    }
}
