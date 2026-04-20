<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class Certificate
{
    /**
     * @param ?list<string> $dns_names
     */
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?array $dns_names = null,
        public ?string $id = null,
        public ?string $name = null,
        public ?DateTimeImmutable $not_after = null,
        public ?string $sha1_fingerprint = null,
        public ?string $state = null,
        public ?string $type = null,
    ) {
    }
}
