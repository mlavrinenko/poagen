<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CustomDeploymentRuleApp
{
    public function __construct(
        public int $id,
        public string $integration_url,
        public string $node_id,
        public string $slug,
    ) {
    }
}
