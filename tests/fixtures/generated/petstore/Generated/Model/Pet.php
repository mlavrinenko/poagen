<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model;

use JsonSerializable;

final readonly class Pet implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract. See ADR-007.
     *
     * phpName => [wireKey, shape]
     * shape is one of: null (scalar pass-through), `\FQCN::class` (model ref), ['list', null] (list<scalar>), ['list', \FQCN::class] (list<Model>).
     *
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}}>
     */
    public const array PROPERTY_MAP = [
        'name' => ['name', null],
        'photoUrls' => ['photoUrls', ['list', null]],
        'category' => ['category', \Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\Category::class],
        'id' => ['id', null],
        'status' => ['status', null],
        'tags' => ['tags', ['list', \Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\Tag::class]],
    ];

    /**
     * @param list<string> $photoUrls
     * @param ?list<\Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\Tag> $tags
     */
    public function __construct(
        public string $name,
        public array $photoUrls,
        public ?Category $category = null,
        public ?int $id = null,
        public ?string $status = null,
        public ?array $tags = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'photoUrls' => $this->photoUrls,
            'category' => $this->category,
            'id' => $this->id,
            'status' => $this->status,
            'tags' => $this->tags,
        ];
    }
}
