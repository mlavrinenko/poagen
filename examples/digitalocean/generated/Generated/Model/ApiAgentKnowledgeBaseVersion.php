<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiAgentKnowledgeBaseVersion
{
    public function __construct(
        public ?bool $is_deleted = null,
        public ?string $name = null,
        public ?string $uuid = null,
    ) {
    }
}
