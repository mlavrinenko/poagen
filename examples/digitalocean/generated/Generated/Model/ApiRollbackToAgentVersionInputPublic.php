<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiRollbackToAgentVersionInputPublic
{
    public function __construct(
        public ?string $uuid = null,
        public ?string $version_hash = null,
    ) {
    }
}
