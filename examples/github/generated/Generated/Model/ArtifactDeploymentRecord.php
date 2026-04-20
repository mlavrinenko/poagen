<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ArtifactDeploymentRecord
{
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
}
