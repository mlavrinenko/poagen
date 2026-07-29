<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class GetWalletLinkResponse
{
    public function __construct(
        public string $result_code,
        public string $result_text,
        public ?string $wallet_link = null,
    ) {
    }
}
