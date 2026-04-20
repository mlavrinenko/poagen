<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\AppAlertProgressStepStatus;
use DateTimeImmutable;

final readonly class AppAlertProgressStep
{
    public function __construct(
        public ?DateTimeImmutable $ended_at = null,
        public ?string $name = null,
        public ?AppAlertProgressStepReason $reason = null,
        public ?DateTimeImmutable $started_at = null,
        public ?AppAlertProgressStepStatus $status = null,
    ) {
    }
}
