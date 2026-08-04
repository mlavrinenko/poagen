<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Unit\Runtime\Fixtures;

final readonly class Animal
{
    public function __construct(
        #[\Poagen\Runtime\Attribute\Discriminator(field: 'petType', map: ['Dog' => Dog::class, 'Cat' => Cat::class])]
        public Dog|Cat|null $creature = null,
    ) {}
}
