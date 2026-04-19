<?php

declare(strict_types=1);

namespace Acme\Petstore\Generated\Model;

use JsonSerializable;

final readonly class Pet implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract. See ADR-007.
     *
     * phpName => [wireKey, shape]
     * shape is one of: null (scalar pass-through), `\FQCN::class` (model ref), ['list', null] (list<scalar>), ['list', \FQCN::class] (list<Model>), ['scalar', \FQCN::class] (ScalarBinding VO), ['datetime', null] (format: date-time → \DateTimeImmutable), ['date', null] (format: date → \DateTimeImmutable), ['enum', \FQCN::class] (named enum component → backed enum), ['union', [\A::class, \B::class, ...], 'propertyName'|null] (oneOf/anyOf of refs; third slot is the discriminator property name or null).
     *
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'name' => ['name', null],
        'photoUrls' => ['photoUrls', ['list', null]],
        'category' => ['category', \Acme\Petstore\Generated\Model\Category::class],
        'id' => ['id', null],
        'shipping' => ['shipping', \Acme\Petstore\Generated\Model\PetShipping::class],
        'status' => ['status', null],
        'tags' => ['tags', ['list', \Acme\Petstore\Generated\Model\Tag::class]],
    ];

    /**
     * @param list<string> $photoUrls
     * @param ?list<\Acme\Petstore\Generated\Model\Tag> $tags
     */
    public function __construct(
        public string $name,
        public array $photoUrls,
        public ?Category $category = null,
        public ?int $id = null,
        public ?PetShipping $shipping = null,
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
            'shipping' => $this->shipping,
            'status' => $this->status,
            'tags' => $this->tags,
        ];
    }
}
