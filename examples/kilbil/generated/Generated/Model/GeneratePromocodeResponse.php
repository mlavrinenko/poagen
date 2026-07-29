<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

use DateTimeImmutable;
use Mlavrinenko\Paogen\Runtime\Attribute\Format;

final readonly class GeneratePromocodeResponse
{
    public function __construct(
        public string $result_code,
        public string $result_text,
        public ?string $promocode = null,
        #[Format('date')]
        public ?DateTimeImmutable $promocode_valid_dt = null,
    ) {
    }
}
