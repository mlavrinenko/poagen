<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppsDeploymentProgress
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppsDeploymentProgressStep> $steps
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppsDeploymentProgressStep> $summary_steps
     */
    public function __construct(
        public ?int $error_steps = null,
        public ?int $pending_steps = null,
        public ?int $running_steps = null,
        public ?array $steps = null,
        public ?int $success_steps = null,
        public ?array $summary_steps = null,
        public ?int $total_steps = null,
    ) {
    }
}
