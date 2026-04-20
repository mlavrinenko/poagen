<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\AppAlertSpecOperator;
use Acme\DigitalOcean\Generated\Enum\AppAlertSpecRule;
use Acme\DigitalOcean\Generated\Enum\AppAlertSpecWindow;

final readonly class AppAlertSpec
{
    public function __construct(
        public ?bool $disabled = null,
        public ?AppAlertSpecOperator $operator = null,
        public ?AppAlertSpecRule $rule = null,
        public ?float $value = null,
        public ?AppAlertSpecWindow $window = null,
    ) {
    }
}
