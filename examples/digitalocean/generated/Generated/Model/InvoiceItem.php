<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class InvoiceItem
{
    public function __construct(
        public ?string $amount = null,
        public ?string $description = null,
        public ?string $duration = null,
        public ?string $duration_unit = null,
        public ?string $end_time = null,
        public ?string $group_description = null,
        public ?string $product = null,
        public ?string $project_name = null,
        public ?string $resource_id = null,
        public ?string $resource_uuid = null,
        public ?string $start_time = null,
    ) {
    }
}
