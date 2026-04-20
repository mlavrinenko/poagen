<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DedicatedInferenceSpec
{
    /**
     * @param list<\Acme\DigitalOcean\Generated\Model\ModelDeploymentSpec> $model_deployments
     */
    public function __construct(
        public bool $enable_public_endpoint,
        public array $model_deployments,
        public string $name,
        public string $region,
        public int $version,
        public DedicatedInferenceSpecVpc $vpc,
    ) {
    }
}
