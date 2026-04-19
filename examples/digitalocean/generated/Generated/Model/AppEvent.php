<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class AppEvent implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'autoscaling' => ['autoscaling', \Acme\DigitalOcean\Generated\Model\AppEventAutoscaling::class],
        'created_at' => ['created_at', ['datetime', null]],
        'deployment' => ['deployment', \Acme\DigitalOcean\Generated\Model\AppsDeployment::class],
        'deployment_id' => ['deployment_id', null],
        'id' => ['id', null],
        'type' => ['type', null],
    ];

    public function __construct(
        public ?AppEventAutoscaling $autoscaling = null,
        public ?DateTimeImmutable $created_at = null,
        public ?AppsDeployment $deployment = null,
        public ?string $deployment_id = null,
        public ?string $id = null,
        public ?string $type = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'autoscaling' => $this->autoscaling,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'deployment' => $this->deployment,
            'deployment_id' => $this->deployment_id,
            'id' => $this->id,
            'type' => $this->type,
        ];
    }
}
