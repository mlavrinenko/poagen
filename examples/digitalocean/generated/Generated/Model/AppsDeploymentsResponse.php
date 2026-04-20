<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppsDeploymentsResponse
{
    /**
     * @param mixed $meta
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppsDeployment> $deployments
     */
    public function __construct(
        public $meta,
        public ?array $deployments = null,
        public ?PageLinks $links = null,
    ) {
    }
}
