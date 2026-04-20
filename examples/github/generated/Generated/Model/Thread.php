<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class Thread
{
    public function __construct(
        public string $id,
        public ?string $last_read_at = null,
        public string $reason,
        public MinimalRepository $repository,
        public ThreadSubject $subject,
        public string $subscription_url,
        public bool $unread,
        public string $updated_at,
        public string $url,
    ) {
    }
}
