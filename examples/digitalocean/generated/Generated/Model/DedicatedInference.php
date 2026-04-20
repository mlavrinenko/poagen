<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class DedicatedInference
{
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?DedicatedInferenceEndpoints $endpoints = null,
        public ?string $id = null,
        public ?PendingDeploymentSpec $pending_deployment_spec = null,
        public ?string $region = null,
        public ?DedicatedInferenceSpec $spec = null,
        public ?string $status = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?string $vpc_uuid = null,
    ) {
    }
}
