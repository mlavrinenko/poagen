<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppComponentInstanceBase implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'autoscaling' => ['autoscaling', \Acme\DigitalOcean\Generated\Model\AppComponentInstanceBaseAutoscaling::class],
        'instance_count' => ['instance_count', null],
        'instance_size_slug' => ['instance_size_slug', null],
    ];

    /**
     * @param ?mixed $instance_size_slug
     */
    public function __construct(
        public ?AppComponentInstanceBaseAutoscaling $autoscaling = null,
        public ?int $instance_count = null,
        public $instance_size_slug = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'autoscaling' => $this->autoscaling,
            'instance_count' => $this->instance_count,
            'instance_size_slug' => $this->instance_size_slug,
        ];
    }
}
