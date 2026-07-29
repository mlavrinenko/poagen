<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class GetProgramGiftCardResponseDataItem
{
    public function __construct(
        public string $aname,
        public string $description,
        public bool $generate_gift_card,
        public int $id,
    ) {
    }
}
