<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class SecretScanningPatternOverride implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'alert_total' => ['alert_total', null],
        'alert_total_percentage' => ['alert_total_percentage', null],
        'bypass_rate' => ['bypass_rate', null],
        'custom_pattern_version' => ['custom_pattern_version', null],
        'default_setting' => ['default_setting', null],
        'display_name' => ['display_name', null],
        'enterprise_setting' => ['enterprise_setting', null],
        'false_positive_rate' => ['false_positive_rate', null],
        'false_positives' => ['false_positives', null],
        'setting' => ['setting', null],
        'slug' => ['slug', null],
        'token_type' => ['token_type', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'alert_total' => $this->alert_total,
            'alert_total_percentage' => $this->alert_total_percentage,
            'bypass_rate' => $this->bypass_rate,
            'custom_pattern_version' => $this->custom_pattern_version,
            'default_setting' => $this->default_setting,
            'display_name' => $this->display_name,
            'enterprise_setting' => $this->enterprise_setting,
            'false_positive_rate' => $this->false_positive_rate,
            'false_positives' => $this->false_positives,
            'setting' => $this->setting,
            'slug' => $this->slug,
            'token_type' => $this->token_type,
        ];
    }
}
