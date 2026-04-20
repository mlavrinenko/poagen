<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class NfsListResponse
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\NfsResponse> $shares
     */
    public function __construct(
        public ?array $shares = null,
    ) {
    }
}
