<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiListAgentVersionsOutput
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiAgentVersion> $agent_versions
     */
    public function __construct(
        public ?array $agent_versions = null,
        public ?ApiLinks $links = null,
        public ?ApiMeta $meta = null,
    ) {
    }
}
