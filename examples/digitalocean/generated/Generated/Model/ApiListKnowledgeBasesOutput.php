<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiListKnowledgeBasesOutput
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiKnowledgeBase> $knowledge_bases
     */
    public function __construct(
        public ?array $knowledge_bases = null,
        public ?ApiLinks $links = null,
        public ?ApiMeta $meta = null,
    ) {
    }
}
