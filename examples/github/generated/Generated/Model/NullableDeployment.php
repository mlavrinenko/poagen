<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class NullableDeployment
{
    /**
     * @param mixed $payload
     */
    public function __construct(
        public DateTimeImmutable $created_at,
        public NullableSimpleUser $creator,
        public ?string $description = null,
        public string $environment,
        public int $id,
        public string $node_id,
        public $payload,
        public string $ref,
        public string $repository_url,
        public string $sha,
        public string $statuses_url,
        public string $task,
        public DateTimeImmutable $updated_at,
        public string $url,
        public ?string $original_environment = null,
        public ?NullableIntegration $performed_via_github_app = null,
        public ?bool $production_environment = null,
        public ?bool $transient_environment = null,
    ) {
    }
}
