<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class PendingDeploymentSpec
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ModelDeploymentSpec> $model_deployments
     */
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?bool $enable_public_endpoint = null,
        public ?string $id = null,
        public ?array $model_deployments = null,
        public ?string $name = null,
        public ?string $status = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?int $version = null,
        public ?PendingDeploymentSpecVpc $vpc = null,
    ) {
    }
}
