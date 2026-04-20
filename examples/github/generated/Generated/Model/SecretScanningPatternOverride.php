<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class SecretScanningPatternOverride
{
    public function __construct(
        public ?int $alert_total = null,
        public ?int $alert_total_percentage = null,
        public ?int $bypass_rate = null,
        public ?string $custom_pattern_version = null,
        public ?string $default_setting = null,
        public ?string $display_name = null,
        public ?string $enterprise_setting = null,
        public ?int $false_positive_rate = null,
        public ?int $false_positives = null,
        public ?string $setting = null,
        public ?string $slug = null,
        public ?string $token_type = null,
    ) {
    }
}
