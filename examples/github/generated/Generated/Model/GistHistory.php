<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class GistHistory
{
    public function __construct(
        public ?GistHistoryChange_status $change_status = null,
        public ?DateTimeImmutable $committed_at = null,
        public ?string $url = null,
        public ?NullableSimpleUser $user = null,
        public ?string $version = null,
    ) {
    }
}
