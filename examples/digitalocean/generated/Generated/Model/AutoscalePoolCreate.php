<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AutoscalePoolCreate implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'config' => [
            'config',
            [
                'union',
                [
                    \Acme\DigitalOcean\Generated\Model\AutoscalePoolStaticConfig::class,
                    \Acme\DigitalOcean\Generated\Model\AutoscalePoolDynamicConfig::class,
                ],
                null,
            ],
        ],
        'droplet_template' => ['droplet_template', \Acme\DigitalOcean\Generated\Model\AutoscalePoolDropletTemplate::class],
        'name' => ['name', null],
    ];

    public function __construct(
        public AutoscalePoolStaticConfig|AutoscalePoolDynamicConfig $config,
        public AutoscalePoolDropletTemplate $droplet_template,
        public string $name,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'config' => $this->config,
            'droplet_template' => $this->droplet_template,
            'name' => $this->name,
        ];
    }
}
