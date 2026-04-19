<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class DedicatedInference implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'endpoints' => ['endpoints', \Acme\DigitalOcean\Generated\Model\DedicatedInferenceEndpoints::class],
        'id' => ['id', null],
        'pending_deployment_spec' => [
            'pending_deployment_spec',
            \Acme\DigitalOcean\Generated\Model\PendingDeploymentSpec::class,
        ],
        'region' => ['region', null],
        'spec' => ['spec', \Acme\DigitalOcean\Generated\Model\DedicatedInferenceSpec::class],
        'status' => ['status', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'vpc_uuid' => ['vpc_uuid', null],
    ];

    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?DedicatedInferenceEndpoints $endpoints = null,
        public ?string $id = null,
        public ?PendingDeploymentSpec $pending_deployment_spec = null,
        public ?string $region = null,
        public ?DedicatedInferenceSpec $spec = null,
        public ?string $status = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?string $vpc_uuid = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'endpoints' => $this->endpoints,
            'id' => $this->id,
            'pending_deployment_spec' => $this->pending_deployment_spec,
            'region' => $this->region,
            'spec' => $this->spec,
            'status' => $this->status,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
            'vpc_uuid' => $this->vpc_uuid,
        ];
    }
}
