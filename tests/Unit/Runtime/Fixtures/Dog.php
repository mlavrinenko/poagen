<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Unit\Runtime\Fixtures;

final readonly class Dog
{
    public function __construct(
        public ?string $petType = null,
        public ?string $bark = null,
    ) {}
}
