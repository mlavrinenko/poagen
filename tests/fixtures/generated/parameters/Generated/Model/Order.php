<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Parameters\Generated\Model;

use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Parameters\Generated\Enum\Status;

final readonly class Order
{
    public function __construct(
        public int $id,
        public ?Status $status = null,
    ) {
    }
}
