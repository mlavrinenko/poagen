<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class SecretScanningPatternConfiguration implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'custom_pattern_overrides' => [
            'custom_pattern_overrides',
            ['list', \Acme\GitHub\Generated\Model\SecretScanningPatternOverride::class],
        ],
        'pattern_config_version' => [
            'pattern_config_version',
            \Acme\GitHub\Generated\Model\SecretScanningRowVersion::class,
        ],
        'provider_pattern_overrides' => [
            'provider_pattern_overrides',
            ['list', \Acme\GitHub\Generated\Model\SecretScanningPatternOverride::class],
        ],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'custom_pattern_overrides' => $this->custom_pattern_overrides,
            'pattern_config_version' => $this->pattern_config_version,
            'provider_pattern_overrides' => $this->provider_pattern_overrides,
        ];
    }
}
