<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class PendingDeploymentEnvironment
{
    public function __construct(
        public ?string $html_url = null,
        public ?int $id = null,
        public ?string $name = null,
        public ?string $node_id = null,
        public ?string $url = null,
    ) {
    }
}
