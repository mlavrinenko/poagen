<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppProposeResponse implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'app_cost' => ['app_cost', null],
        'app_is_static' => ['app_is_static', null],
        'app_name_available' => ['app_name_available', null],
        'app_name_suggestion' => ['app_name_suggestion', null],
        'app_tier_downgrade_cost' => ['app_tier_downgrade_cost', null],
        'existing_static_apps' => ['existing_static_apps', null],
        'spec' => ['spec', \Acme\DigitalOcean\Generated\Model\AppSpec::class],
    ];

    public function __construct(
        public ?int $app_cost = null,
        public ?bool $app_is_static = null,
        public ?bool $app_name_available = null,
        public ?string $app_name_suggestion = null,
        public ?int $app_tier_downgrade_cost = null,
        public ?string $existing_static_apps = null,
        public ?AppSpec $spec = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'app_cost' => $this->app_cost,
            'app_is_static' => $this->app_is_static,
            'app_name_available' => $this->app_name_available,
            'app_name_suggestion' => $this->app_name_suggestion,
            'app_tier_downgrade_cost' => $this->app_tier_downgrade_cost,
            'existing_static_apps' => $this->existing_static_apps,
            'spec' => $this->spec,
        ];
    }
}
