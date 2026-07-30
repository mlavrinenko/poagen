<?php

declare(strict_types=1);

namespace Acme\Petstore\Generated\Model;

use Acme\Petstore\Generated\Enum\PetStatus;

final readonly class Pet
{
    /**
     * @param list<string> $photoUrls
     * @param ?list<Tag> $tags
     */
    public function __construct(
        public string $name,
        public array $photoUrls,
        public ?Category $category = null,
        public ?int $id = null,
        public ?PetShipping $shipping = null,
        public ?PetStatus $status = null,
        public ?array $tags = null,
    ) {
    }
}
