<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class PendingDeploymentSpec implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'enable_public_endpoint' => ['enable_public_endpoint', null],
        'id' => ['id', null],
        'model_deployments' => [
            'model_deployments',
            ['list', \Acme\DigitalOcean\Generated\Model\ModelDeploymentSpec::class],
        ],
        'name' => ['name', null],
        'status' => ['status', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'version' => ['version', null],
        'vpc' => ['vpc', \Acme\DigitalOcean\Generated\Model\PendingDeploymentSpecVpc::class],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ModelDeploymentSpec> $model_deployments
     */
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?bool $enable_public_endpoint = null,
        public ?string $id = null,
        public ?array $model_deployments = null,
        public ?string $name = null,
        public ?string $status = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?int $version = null,
        public ?PendingDeploymentSpecVpc $vpc = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'enable_public_endpoint' => $this->enable_public_endpoint,
            'id' => $this->id,
            'model_deployments' => $this->model_deployments,
            'name' => $this->name,
            'status' => $this->status,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
            'version' => $this->version,
            'vpc' => $this->vpc,
        ];
    }
}
