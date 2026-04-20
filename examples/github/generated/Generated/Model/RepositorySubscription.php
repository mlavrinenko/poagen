<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class RepositorySubscription
{
    public function __construct(
        public DateTimeImmutable $created_at,
        public bool $ignored,
        public ?string $reason = null,
        public string $repository_url,
        public bool $subscribed,
        public string $url,
    ) {
    }
}
