<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class ThreadSubscription
{
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public bool $ignored,
        public ?string $reason = null,
        public bool $subscribed,
        public string $url,
        public ?string $repository_url = null,
        public ?string $thread_url = null,
    ) {
    }
}
