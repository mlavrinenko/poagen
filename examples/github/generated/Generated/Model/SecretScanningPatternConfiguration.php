<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class SecretScanningPatternConfiguration
{
    /**
     * @param ?list<\Acme\GitHub\Generated\Model\SecretScanningPatternOverride> $custom_pattern_overrides
     * @param ?list<\Acme\GitHub\Generated\Model\SecretScanningPatternOverride> $provider_pattern_overrides
     */
    public function __construct(
        public ?array $custom_pattern_overrides = null,
        public ?SecretScanningRowVersion $pattern_config_version = null,
        public ?array $provider_pattern_overrides = null,
    ) {
    }
}
