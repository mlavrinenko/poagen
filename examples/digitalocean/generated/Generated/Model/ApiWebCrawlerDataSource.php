<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\ApiCrawlingOption;

final readonly class ApiWebCrawlerDataSource
{
    /**
     * @param ?list<string> $exclude_tags
     */
    public function __construct(
        public ?string $base_url = null,
        public ?ApiCrawlingOption $crawling_option = null,
        public ?bool $embed_media = null,
        public ?array $exclude_tags = null,
    ) {
    }
}
