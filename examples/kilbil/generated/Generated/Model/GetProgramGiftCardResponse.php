<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class GetProgramGiftCardResponse
{
    /**
     * @param list<\Acme\Kilbil\Generated\Model\GetProgramGiftCardResponseDataItem> $data
     */
    public function __construct(
        public array $data,
        public string $result_code,
    ) {
    }
}
