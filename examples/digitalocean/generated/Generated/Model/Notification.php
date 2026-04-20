<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class Notification
{
    /**
     * @param list<string> $email
     * @param list<array<string, mixed>> $slack
     */
    public function __construct(
        public array $email,
        public array $slack,
    ) {
    }
}
