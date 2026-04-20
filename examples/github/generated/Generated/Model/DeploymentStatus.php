<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class DeploymentStatus
{
    public function __construct(
        public DateTimeImmutable $created_at,
        public NullableSimpleUser $creator,
        public string $deployment_url,
        public string $description,
        public int $id,
        public string $node_id,
        public string $repository_url,
        public string $state,
        public string $target_url,
        public DateTimeImmutable $updated_at,
        public string $url,
        public ?string $environment = null,
        public ?string $environment_url = null,
        public ?string $log_url = null,
        public ?NullableIntegration $performed_via_github_app = null,
    ) {
    }
}
