<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CheckImmutableReleases
{
    public function __construct(
        public bool $enabled,
        public bool $enforced_by_owner,
    ) {
    }
}
