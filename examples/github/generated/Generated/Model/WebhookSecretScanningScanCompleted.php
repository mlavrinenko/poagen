<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhookSecretScanningScanCompleted
{
    /**
     * @param ?list<string> $secret_types
     */
    public function __construct(
        public string $action,
        public DateTimeImmutable $completed_at,
        public string $source,
        public DateTimeImmutable $started_at,
        public string $type,
        public ?string $custom_pattern_name = null,
        public ?string $custom_pattern_scope = null,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?RepositoryWebhooks $repository = null,
        public ?array $secret_types = null,
        public ?SimpleUser $sender = null,
    ) {
    }
}
