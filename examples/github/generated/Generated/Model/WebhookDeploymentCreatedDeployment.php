<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookDeploymentCreatedDeployment
{
    /**
     * @param mixed $payload
     */
    public function __construct(
        public string $created_at,
        public WebhookDeploymentCreatedDeploymentCreator $creator,
        public ?string $description = null,
        public string $environment,
        public int $id,
        public string $node_id,
        public string $original_environment,
        public $payload,
        public string $ref,
        public string $repository_url,
        public string $sha,
        public string $statuses_url,
        public string $task,
        public string $updated_at,
        public string $url,
        public ?WebhookDeploymentCreatedDeploymentPerformed_via_github_app $performed_via_github_app = null,
        public ?bool $production_environment = null,
        public ?bool $transient_environment = null,
    ) {
    }
}
