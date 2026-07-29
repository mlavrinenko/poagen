<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

use Acme\Kilbil\Generated\Enum\ReplaceCardRequestSearchMode;

final readonly class ReplaceCardRequest
{
    public function __construct(
        public int $client_id,
        public ReplaceCardRequestSearchMode $search_mode,
        public string $search_value,
    ) {
    }
}
