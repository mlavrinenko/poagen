<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class OidcCustomSubRepo
{
    /**
     * @param ?list<string> $include_claim_keys
     */
    public function __construct(
        public bool $use_default,
        public ?array $include_claim_keys = null,
    ) {
    }
}
