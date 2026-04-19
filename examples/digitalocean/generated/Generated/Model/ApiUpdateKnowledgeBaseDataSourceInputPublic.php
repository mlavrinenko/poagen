<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\ApiChunkingAlgorithm;
use JsonSerializable;

final readonly class ApiUpdateKnowledgeBaseDataSourceInputPublic implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'chunking_algorithm' => [
            'chunking_algorithm',
            ['enum', \Acme\DigitalOcean\Generated\Enum\ApiChunkingAlgorithm::class],
        ],
        'chunking_options' => ['chunking_options', \Acme\DigitalOcean\Generated\Model\ApiChunkingOptions::class],
        'data_source_uuid' => ['data_source_uuid', null],
        'knowledge_base_uuid' => ['knowledge_base_uuid', null],
    ];

    public function __construct(
        public ?ApiChunkingAlgorithm $chunking_algorithm = null,
        public ?ApiChunkingOptions $chunking_options = null,
        public ?string $data_source_uuid = null,
        public ?string $knowledge_base_uuid = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'chunking_algorithm' => $this->chunking_algorithm,
            'chunking_options' => $this->chunking_options,
            'data_source_uuid' => $this->data_source_uuid,
            'knowledge_base_uuid' => $this->knowledge_base_uuid,
        ];
    }
}
