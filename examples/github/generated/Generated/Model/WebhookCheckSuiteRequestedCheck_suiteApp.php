<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhookCheckSuiteRequestedCheck_suiteApp
{
    /**
     * @param ?list<string> $events
     */
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?string $description = null,
        public ?string $external_url = null,
        public string $html_url,
        public ?int $id = null,
        public string $name,
        public string $node_id,
        public WebhookCheckSuiteRequestedCheck_suiteAppOwner $owner,
        public ?DateTimeImmutable $updated_at = null,
        public ?string $client_id = null,
        public ?array $events = null,
        public ?WebhookCheckSuiteRequestedCheck_suiteAppPermissions $permissions = null,
        public ?string $slug = null,
    ) {
    }
}
