<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

use DateTimeImmutable;
use Mlavrinenko\Paogen\Runtime\Attribute\Format;

final readonly class GetSalesIndicesSlidesRequest
{
    public function __construct(
        #[Format('date')]
        public ?DateTimeImmutable $date = null,
    ) {
    }
}
