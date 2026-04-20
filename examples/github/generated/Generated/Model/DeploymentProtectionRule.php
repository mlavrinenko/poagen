<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class DeploymentProtectionRule
{
    public function __construct(
        public CustomDeploymentRuleApp $app,
        public bool $enabled,
        public int $id,
        public string $node_id,
    ) {
    }
}
