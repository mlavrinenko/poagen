<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiRollbackToAgentVersionOutput
{
    public function __construct(
        public ?ApiAuditHeader $audit_header = null,
        public ?string $version_hash = null,
    ) {
    }
}
