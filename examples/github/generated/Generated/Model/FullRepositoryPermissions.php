<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class FullRepositoryPermissions
{
    public function __construct(
        public bool $admin,
        public bool $pull,
        public bool $push,
        public ?bool $maintain = null,
        public ?bool $triage = null,
    ) {
    }
}
