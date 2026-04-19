<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiDeleteKnowledgeBaseDataSourceOutput implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'data_source_uuid' => ['data_source_uuid', null],
        'knowledge_base_uuid' => ['knowledge_base_uuid', null],
    ];

    public function __construct(
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
            'data_source_uuid' => $this->data_source_uuid,
            'knowledge_base_uuid' => $this->knowledge_base_uuid,
        ];
    }
}
