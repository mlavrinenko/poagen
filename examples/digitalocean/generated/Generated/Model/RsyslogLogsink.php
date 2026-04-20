<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class RsyslogLogsink
{
    public function __construct(
        public string $format,
        public int $port,
        public string $server,
        public bool $tls,
        public ?string $ca = null,
        public ?string $cert = null,
        public ?string $key = null,
        public ?string $logline = null,
        public ?string $sd = null,
    ) {
    }
}
