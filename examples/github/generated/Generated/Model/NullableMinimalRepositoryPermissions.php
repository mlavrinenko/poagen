<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class NullableMinimalRepositoryPermissions
{
    public function __construct(
        public ?bool $admin = null,
        public ?bool $maintain = null,
        public ?bool $pull = null,
        public ?bool $push = null,
        public ?bool $triage = null,
    ) {
    }
}
