<?php

declare(strict_types=1);

namespace Acme\Petstore\Generated\Model;

final readonly class Pet
{
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
}
