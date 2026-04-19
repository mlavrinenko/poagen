<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\DbaasClusterStatus;
use JsonSerializable;

final readonly class ApiGetKnowledgeBaseOutput implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'database_status' => ['database_status', ['enum', \Acme\DigitalOcean\Generated\Enum\DbaasClusterStatus::class]],
        'knowledge_base' => ['knowledge_base', \Acme\DigitalOcean\Generated\Model\ApiKnowledgeBase::class],
    ];

    public function __construct(
        public ?DbaasClusterStatus $database_status = null,
        public ?ApiKnowledgeBase $knowledge_base = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'database_status' => $this->database_status,
            'knowledge_base' => $this->knowledge_base,
        ];
    }
}
