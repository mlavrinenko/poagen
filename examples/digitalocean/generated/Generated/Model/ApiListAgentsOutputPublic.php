<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiListAgentsOutputPublic
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiAgentPublic> $agents
     */
    public function __construct(
        public ?array $agents = null,
        public ?ApiLinks $links = null,
        public ?ApiMeta $meta = null,
    ) {
    }
}
