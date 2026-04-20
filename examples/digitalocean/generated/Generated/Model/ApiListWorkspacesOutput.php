<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiListWorkspacesOutput
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiWorkspace> $workspaces
     */
    public function __construct(
        public ?array $workspaces = null,
    ) {
    }
}
