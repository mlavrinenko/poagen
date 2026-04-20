<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\AppsDeploymentProgressStepStatus;
use DateTimeImmutable;

final readonly class AppsDeploymentProgressStep
{
    /**
     * @param ?list<array<string, mixed>> $steps
     */
    public function __construct(
        public ?string $component_name = null,
        public ?DateTimeImmutable $ended_at = null,
        public ?string $message_base = null,
        public ?string $name = null,
        public ?AppsDeploymentProgressStepReason $reason = null,
        public ?DateTimeImmutable $started_at = null,
        public ?AppsDeploymentProgressStepStatus $status = null,
        public ?array $steps = null,
    ) {
    }
}
