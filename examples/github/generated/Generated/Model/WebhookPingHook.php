<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhookPingHook
{
    /**
     * @param list<string> $events
     */
    public function __construct(
        public bool $active,
        public WebhookPingHookConfig $config,
        public DateTimeImmutable $created_at,
        public array $events,
        public int $id,
        public string $name,
        public string $type,
        public DateTimeImmutable $updated_at,
        public ?int $app_id = null,
        public ?string $deliveries_url = null,
        public ?HookResponse $last_response = null,
        public ?string $ping_url = null,
        public ?string $test_url = null,
        public ?string $url = null,
    ) {
    }
}
