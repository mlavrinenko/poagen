<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiDeleteScheduledIndexingOutput
{
    public function __construct(
        public ?ApiScheduledIndexingInfo $indexing_info = null,
    ) {
    }
}
