<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Unit\Runtime\Fixtures;

final readonly class Cat
{
    public function __construct(
        public ?string $petType = null,
        public ?string $meow = null,
    ) {}
}
