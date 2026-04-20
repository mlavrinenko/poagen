<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppsGetLogsResponse
{
    /**
     * @param ?list<string> $historic_urls
     */
    public function __construct(
        public ?array $historic_urls = null,
        public ?string $live_url = null,
    ) {
    }
}
