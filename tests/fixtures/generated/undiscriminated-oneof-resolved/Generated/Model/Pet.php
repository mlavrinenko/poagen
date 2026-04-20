<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\UndiscriminatedOneofResolved\Generated\Model;

use Mlavrinenko\Paogen\Runtime\Attribute\Discriminator;

final readonly class Pet
{
    public function __construct(
        #[Discriminator(
            field: 'petType',
            map: [
            'Dog' => \Mlavrinenko\Paogen\Tests\Fixtures\Generated\UndiscriminatedOneofResolved\Generated\Model\Dog::class,
            'Cat' => \Mlavrinenko\Paogen\Tests\Fixtures\Generated\UndiscriminatedOneofResolved\Generated\Model\Cat::class,
        ],
        )]
        public Dog|Cat $kind,
    ) {
    }
}
