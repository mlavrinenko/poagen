<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class GoodsXmlResponse
{
    public function __construct(
        public string $result_code,
        public ?int $success = null,
    ) {
    }
}
