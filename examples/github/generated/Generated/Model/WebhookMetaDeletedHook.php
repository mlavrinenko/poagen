<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookMetaDeletedHook
{
    /**
     * @param list<string> $events
     */
    public function __construct(
        public bool $active,
        public WebhookMetaDeletedHookConfig $config,
        public string $created_at,
        public array $events,
        public int $id,
        public string $name,
        public string $type,
        public string $updated_at,
    ) {
    }
}
