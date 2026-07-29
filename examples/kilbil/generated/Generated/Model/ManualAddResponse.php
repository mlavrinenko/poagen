<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class ManualAddResponse
{
    public function __construct(
        public int $result_code,
        public string $result_text,
    ) {
    }
}
