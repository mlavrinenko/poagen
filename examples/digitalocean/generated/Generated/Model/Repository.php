<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class Repository implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'latest_tag' => ['latest_tag', \Acme\DigitalOcean\Generated\Model\RepositoryTag::class],
        'name' => ['name', null],
        'registry_name' => ['registry_name', null],
        'tag_count' => ['tag_count', null],
    ];

    public function __construct(
        public ?RepositoryTag $latest_tag = null,
        public ?string $name = null,
        public ?string $registry_name = null,
        public ?int $tag_count = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'latest_tag' => $this->latest_tag,
            'name' => $this->name,
            'registry_name' => $this->registry_name,
            'tag_count' => $this->tag_count,
        ];
    }
}
