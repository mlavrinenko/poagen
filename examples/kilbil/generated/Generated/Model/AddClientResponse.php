<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class AddClientResponse
{
    public function __construct(
        public int $client_id,
        public string $result_code,
        public string $result_text,
        public ?int $success = null,
    ) {
    }
}
