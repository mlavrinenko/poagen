<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ArtifactDeploymentRecord implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'attestation_id' => ['attestation_id', null],
        'cluster' => ['cluster', null],
        'created_at' => ['created_at', null],
        'deployment_name' => ['deployment_name', null],
        'digest' => ['digest', null],
        'id' => ['id', null],
        'logical_environment' => ['logical_environment', null],
        'physical_environment' => ['physical_environment', null],
        'runtime_risks' => ['runtime_risks', ['list', null]],
        'tags' => ['tags', null],
        'updated_at' => ['updated_at', null],
    ];

    /**
     * @param ?list<string> $runtime_risks
     * @param ?array<string, string> $tags
     */
    public function __construct(
        public ?int $attestation_id = null,
        public ?string $cluster = null,
        public ?string $created_at = null,
        public ?string $deployment_name = null,
        public ?string $digest = null,
        public ?int $id = null,
        public ?string $logical_environment = null,
        public ?string $physical_environment = null,
        public ?array $runtime_risks = null,
        public ?array $tags = null,
        public ?string $updated_at = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'attestation_id' => $this->attestation_id,
            'cluster' => $this->cluster,
            'created_at' => $this->created_at,
            'deployment_name' => $this->deployment_name,
            'digest' => $this->digest,
            'id' => $this->id,
            'logical_environment' => $this->logical_environment,
            'physical_environment' => $this->physical_environment,
            'runtime_risks' => $this->runtime_risks,
            'tags' => $this->tags,
            'updated_at' => $this->updated_at,
        ];
    }
}
