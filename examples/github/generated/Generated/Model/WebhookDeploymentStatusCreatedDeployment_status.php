<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookDeploymentStatusCreatedDeployment_status
{
    public function __construct(
        public string $created_at,
        public WebhookDeploymentStatusCreatedDeployment_statusCreator $creator,
        public string $deployment_url,
        public string $description,
        public string $environment,
        public int $id,
        public string $node_id,
        public string $repository_url,
        public string $state,
        public string $target_url,
        public string $updated_at,
        public string $url,
        public ?string $environment_url = null,
        public ?string $log_url = null,
        public ?WebhookDeploymentStatusCreatedDeployment_statusPerformed_via_github_app $performed_via_github_app = null,
    ) {
    }
}
