<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiListKnowledgeBasesOutput implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'knowledge_bases' => ['knowledge_bases', ['list', \Acme\DigitalOcean\Generated\Model\ApiKnowledgeBase::class]],
        'links' => ['links', \Acme\DigitalOcean\Generated\Model\ApiLinks::class],
        'meta' => ['meta', \Acme\DigitalOcean\Generated\Model\ApiMeta::class],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiKnowledgeBase> $knowledge_bases
     */
    public function __construct(
        public ?array $knowledge_bases = null,
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
            'knowledge_bases' => $this->knowledge_bases,
            'links' => $this->links,
            'meta' => $this->meta,
        ];
    }
}
