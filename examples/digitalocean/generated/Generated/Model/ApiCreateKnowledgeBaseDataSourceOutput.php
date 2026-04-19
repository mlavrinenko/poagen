<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiCreateKnowledgeBaseDataSourceOutput implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'knowledge_base_data_source' => [
            'knowledge_base_data_source',
            \Acme\DigitalOcean\Generated\Model\ApiKnowledgeBaseDataSource::class,
        ],
    ];

    public function __construct(
        public ?ApiKnowledgeBaseDataSource $knowledge_base_data_source = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'knowledge_base_data_source' => $this->knowledge_base_data_source,
        ];
    }
}
