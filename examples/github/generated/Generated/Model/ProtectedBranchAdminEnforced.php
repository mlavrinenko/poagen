<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ProtectedBranchAdminEnforced
{
    public function __construct(
        public bool $enabled,
        public string $url,
    ) {
    }
}
