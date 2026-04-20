<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class UserKubernetes_cluster_user
{
    /**
     * @param ?list<string> $groups
     */
    public function __construct(
        public ?array $groups = null,
        public ?string $username = null,
    ) {
    }
}
