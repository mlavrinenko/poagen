<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ForwardingRule
{
    public function __construct(
        public int $entry_port,
        public string $entry_protocol,
        public int $target_port,
        public string $target_protocol,
        public ?string $certificate_id = null,
        public ?bool $tls_passthrough = null,
    ) {
    }
}
