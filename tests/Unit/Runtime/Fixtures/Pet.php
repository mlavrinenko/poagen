<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Unit\Runtime\Fixtures;

final readonly class Pet
{
    /**
     * @param list<string>|null $photoUrls
     * @param list<Tag>|null $tags
     */
    public function __construct(
        public ?int $id = null,
        public ?string $name = null,
        public ?array $photoUrls = null,
        public ?array $tags = null,
    ) {}
}
