<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookDeploymentProtectionRuleRequested
{
    /**
     * @param ?list<\Acme\GitHub\Generated\Model\PullRequest> $pull_requests
     */
    public function __construct(
        public ?string $action = null,
        public ?NullableDeployment $deployment = null,
        public ?string $deployment_callback_url = null,
        public ?string $environment = null,
        public ?string $event = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?array $pull_requests = null,
        public ?string $ref = null,
        public ?RepositoryWebhooks $repository = null,
        public ?SimpleUser $sender = null,
        public ?string $sha = null,
    ) {
    }
}
