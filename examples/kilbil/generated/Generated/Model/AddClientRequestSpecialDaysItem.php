<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

use DateTimeImmutable;
use Mlavrinenko\Paogen\Runtime\Attribute\Format;

final readonly class AddClientRequestSpecialDaysItem
{
    public function __construct(
        public ?int $id = null,
        #[Format('date')]
        public ?DateTimeImmutable $value = null,
    ) {
    }
}
