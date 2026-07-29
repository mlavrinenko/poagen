<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class BlockCardResponse
{
    public function __construct(
        public string $result_code,
        public string $result_text,
    ) {
    }
}
