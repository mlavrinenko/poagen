<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\ApiCrawlingOption;
use JsonSerializable;

final readonly class ApiWebCrawlerDataSource implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'base_url' => ['base_url', null],
        'crawling_option' => ['crawling_option', ['enum', \Acme\DigitalOcean\Generated\Enum\ApiCrawlingOption::class]],
        'embed_media' => ['embed_media', null],
        'exclude_tags' => ['exclude_tags', ['list', null]],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'base_url' => $this->base_url,
            'crawling_option' => $this->crawling_option,
            'embed_media' => $this->embed_media,
            'exclude_tags' => $this->exclude_tags,
        ];
    }
}
