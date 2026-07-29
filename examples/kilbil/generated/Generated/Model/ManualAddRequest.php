<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

use DateTimeImmutable;
use Mlavrinenko\Paogen\Runtime\Attribute\Format;

final readonly class ManualAddRequest
{
    public function __construct(
        public int $client_id,
        public ?float $bonus_in = null,
        public ?float $bonus_out = null,
        public ?string $description = null,
        #[Format('date')]
        public ?DateTimeImmutable $expire_date = null,
        public ?float $total = null,
    ) {
    }
}
