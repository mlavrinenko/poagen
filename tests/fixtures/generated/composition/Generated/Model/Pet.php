<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Composition\Generated\Model;

use Mlavrinenko\Paogen\Runtime\Attribute\Discriminator;

final readonly class Pet
{
    public function __construct(
        #[Discriminator(field: 'petType', map: ['Dog' => Dog::class, 'Cat' => Cat::class])]
        public Dog|Cat $kind,
    ) {
    }
}
