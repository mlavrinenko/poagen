<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class KeyCreateResponse
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\Grant> $grants
     */
    public function __construct(
        public ?string $access_key = null,
        public ?DateTimeImmutable $created_at = null,
        public ?array $grants = null,
        public ?string $name = null,
        public ?string $secret_key = null,
    ) {
    }
}
