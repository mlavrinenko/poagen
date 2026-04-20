<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class OrgHook
{
    /**
     * @param list<string> $events
     */
    public function __construct(
        public bool $active,
        public OrgHookConfig $config,
        public DateTimeImmutable $created_at,
        public array $events,
        public int $id,
        public string $name,
        public string $ping_url,
        public string $type,
        public DateTimeImmutable $updated_at,
        public string $url,
        public ?string $deliveries_url = null,
    ) {
    }
}
