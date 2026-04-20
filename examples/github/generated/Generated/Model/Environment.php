<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class Environment
{
    /**
     * @param ?list<mixed> $protection_rules
     */
    public function __construct(
        public DateTimeImmutable $created_at,
        public string $html_url,
        public int $id,
        public string $name,
        public string $node_id,
        public DateTimeImmutable $updated_at,
        public string $url,
        public ?DeploymentBranchPolicySettings $deployment_branch_policy = null,
        public ?array $protection_rules = null,
    ) {
    }
}
