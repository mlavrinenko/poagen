<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class LogsinkVerbose
{
    public function __construct(
        public RsyslogLogsink|ElasticsearchLogsink|OpensearchLogsink|DatadogLogsink|null $config = null,
        public ?string $sink_id = null,
        public ?string $sink_name = null,
        public ?string $sink_type = null,
    ) {
    }
}
