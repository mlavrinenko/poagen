<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppMaintenanceSpec
{
    public function __construct(
        public ?bool $archive = null,
        public ?bool $enabled = null,
        public ?string $offline_page_url = null,
    ) {
    }
}
