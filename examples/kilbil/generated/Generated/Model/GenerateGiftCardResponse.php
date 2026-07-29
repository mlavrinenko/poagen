<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

use Acme\Kilbil\Generated\Enum\GenerateGiftCardResponseGcState;

final readonly class GenerateGiftCardResponse
{
    public function __construct(
        public float $gc_balance,
        public string $gc_barcode,
        public string $gc_code,
        public GenerateGiftCardResponseGcState $gc_state,
        public string $gc_state_text,
        public string $result_code,
        public string $result_text,
    ) {
    }
}
