<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiListKnowledgeBaseDataSourcesOutput implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'knowledge_base_data_sources' => [
            'knowledge_base_data_sources',
            ['list', \Acme\DigitalOcean\Generated\Model\ApiKnowledgeBaseDataSource::class],
        ],
        'links' => ['links', \Acme\DigitalOcean\Generated\Model\ApiLinks::class],
        'meta' => ['meta', \Acme\DigitalOcean\Generated\Model\ApiMeta::class],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiKnowledgeBaseDataSource> $knowledge_base_data_sources
     */
    public function __construct(
        public ?array $knowledge_base_data_sources = null,
        public ?ApiLinks $links = null,
        public ?ApiMeta $meta = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'knowledge_base_data_sources' => $this->knowledge_base_data_sources,
            'links' => $this->links,
            'meta' => $this->meta,
        ];
    }
}
