<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class Alerts
{
    /**
     * @param list<string> $email
     * @param list<\Acme\DigitalOcean\Generated\Model\SlackDetails> $slack
     */
    public function __construct(
        public array $email,
        public array $slack,
    ) {
    }
}
