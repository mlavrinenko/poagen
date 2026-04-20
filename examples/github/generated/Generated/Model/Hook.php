<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class Hook
{
    /**
     * @param list<string> $events
     */
    public function __construct(
        public bool $active,
        public WebhookConfig $config,
        public DateTimeImmutable $created_at,
        public array $events,
        public int $id,
        public HookResponse $last_response,
        public string $name,
        public string $ping_url,
        public string $test_url,
        public string $type,
        public DateTimeImmutable $updated_at,
        public string $url,
        public ?string $deliveries_url = null,
    ) {
    }
}
