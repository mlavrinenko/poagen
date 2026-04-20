<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class LogsinkUpdate
{
    public function __construct(
        public RsyslogLogsink|ElasticsearchLogsink|OpensearchLogsink|DatadogLogsink $config,
    ) {
    }
}
