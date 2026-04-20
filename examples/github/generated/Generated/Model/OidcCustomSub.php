<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class OidcCustomSub
{
    /**
     * @param list<string> $include_claim_keys
     */
    public function __construct(
        public array $include_claim_keys,
    ) {
    }
}
