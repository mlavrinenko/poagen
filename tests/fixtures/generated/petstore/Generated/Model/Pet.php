<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model;

use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Enum\PetStatus;

final readonly class Pet
{
    /**
     * @param list<string> $photoUrls
     * @param ?list<\Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\Tag> $tags
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
