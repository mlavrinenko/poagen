<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class DedicatedInferenceSpec implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'enable_public_endpoint' => ['enable_public_endpoint', null],
        'model_deployments' => [
            'model_deployments',
            ['list', \Acme\DigitalOcean\Generated\Model\ModelDeploymentSpec::class],
        ],
        'name' => ['name', null],
        'region' => ['region', null],
        'version' => ['version', null],
        'vpc' => ['vpc', \Acme\DigitalOcean\Generated\Model\DedicatedInferenceSpecVpc::class],
    ];

    /**
     * @param list<\Acme\DigitalOcean\Generated\Model\ModelDeploymentSpec> $model_deployments
     */
    public function __construct(
        public bool $enable_public_endpoint,
        public array $model_deployments,
        public string $name,
        public string $region,
        public int $version,
        public DedicatedInferenceSpecVpc $vpc,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'enable_public_endpoint' => $this->enable_public_endpoint,
            'model_deployments' => $this->model_deployments,
            'name' => $this->name,
            'region' => $this->region,
            'version' => $this->version,
            'vpc' => $this->vpc,
        ];
    }
}
