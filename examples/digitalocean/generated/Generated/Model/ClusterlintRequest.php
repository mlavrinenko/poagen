<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ClusterlintRequest
{
    /**
     * @param ?list<string> $exclude_checks
     * @param ?list<string> $exclude_groups
     * @param ?list<string> $include_checks
     * @param ?list<string> $include_groups
     */
    public function __construct(
        public ?array $exclude_checks = null,
        public ?array $exclude_groups = null,
        public ?array $include_checks = null,
        public ?array $include_groups = null,
    ) {
    }
}
