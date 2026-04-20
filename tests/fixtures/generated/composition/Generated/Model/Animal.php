<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Composition\Generated\Model;

final readonly class Animal
{
    public function __construct(
        public Dog|Cat $creature,
    ) {
    }
}
