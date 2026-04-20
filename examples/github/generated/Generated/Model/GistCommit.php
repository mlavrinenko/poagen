<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class GistCommit
{
    public function __construct(
        public GistCommitChange_status $change_status,
        public DateTimeImmutable $committed_at,
        public string $url,
        public NullableSimpleUser $user,
        public string $version,
    ) {
    }
}
