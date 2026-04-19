<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AddonsResource implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'app_slug' => ['app_slug', null],
        'has_config' => ['has_config', null],
        'name' => ['name', null],
        'plan_slug' => ['plan_slug', null],
        'state' => ['state', null],
        'uuid' => ['uuid', null],
        'app_name' => ['app_name', null],
        'message' => ['message', null],
        'metadata' => ['metadata', ['list', \Acme\DigitalOcean\Generated\Model\AddonsResourceMetadata::class]],
        'plan_name' => ['plan_name', null],
        'plan_price_per_month' => ['plan_price_per_month', null],
        'sso_url' => ['sso_url', null],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AddonsResourceMetadata> $metadata
     */
    public function __construct(
        public string $app_slug,
        public bool $has_config,
        public string $name,
        public string $plan_slug,
        public string $state,
        public string $uuid,
        public ?string $app_name = null,
        public ?string $message = null,
        public ?array $metadata = null,
        public ?string $plan_name = null,
        public ?int $plan_price_per_month = null,
        public ?string $sso_url = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'app_slug' => $this->app_slug,
            'has_config' => $this->has_config,
            'name' => $this->name,
            'plan_slug' => $this->plan_slug,
            'state' => $this->state,
            'uuid' => $this->uuid,
            'app_name' => $this->app_name,
            'message' => $this->message,
            'metadata' => $this->metadata,
            'plan_name' => $this->plan_name,
            'plan_price_per_month' => $this->plan_price_per_month,
            'sso_url' => $this->sso_url,
        ];
    }
}
