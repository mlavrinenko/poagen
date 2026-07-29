<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

use DateTimeImmutable;
use Mlavrinenko\Paogen\Runtime\Attribute\Format;

final readonly class SearchClientResponseSpecialDaysTypesItem
{
    public function __construct(
        public string $aname,
        public int $id,
        #[Format('date')]
        public ?DateTimeImmutable $value,
    ) {
    }
}
