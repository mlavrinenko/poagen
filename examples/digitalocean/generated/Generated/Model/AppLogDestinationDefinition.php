<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppLogDestinationDefinition
{
    public function __construct(
        public string $name,
        public ?AppLogDestinationDatadogSpec $datadog = null,
        public ?AppLogDestinationLogtailSpec $logtail = null,
        public ?AppLogDestinationOpenSearchSpec $open_search = null,
        public ?AppLogDestinationPapertrailSpec $papertrail = null,
    ) {
    }
}
