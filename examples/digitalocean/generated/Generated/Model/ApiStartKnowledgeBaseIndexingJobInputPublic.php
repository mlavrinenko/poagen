<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiStartKnowledgeBaseIndexingJobInputPublic implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'data_source_uuids' => ['data_source_uuids', ['list', null]],
        'knowledge_base_uuid' => ['knowledge_base_uuid', null],
    ];

    /**
     * @param ?list<string> $data_source_uuids
     */
    public function __construct(
        public ?array $data_source_uuids = null,
        public ?string $knowledge_base_uuid = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'data_source_uuids' => $this->data_source_uuids,
            'knowledge_base_uuid' => $this->knowledge_base_uuid,
        ];
    }
}
