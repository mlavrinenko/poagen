<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class SlackDetails
{
    public function __construct(
        public string $channel,
        public string $url,
    ) {
    }
}
