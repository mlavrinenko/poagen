<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class TeamPermissions
{
    public function __construct(
        public bool $admin,
        public bool $maintain,
        public bool $pull,
        public bool $push,
        public bool $triage,
    ) {
    }
}
