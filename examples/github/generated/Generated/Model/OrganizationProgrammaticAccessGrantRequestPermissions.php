<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class OrganizationProgrammaticAccessGrantRequestPermissions
{
    /**
     * @param ?array<string, string> $organization
     * @param ?array<string, string> $other
     * @param ?array<string, string> $repository
     */
    public function __construct(
        public ?array $organization = null,
        public ?array $other = null,
        public ?array $repository = null,
    ) {
    }
}
