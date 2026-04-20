<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ApiOverviewDomainsActions_inbound
{
    /**
     * @param ?list<string> $full_domains
     * @param ?list<string> $wildcard_domains
     */
    public function __construct(
        public ?array $full_domains = null,
        public ?array $wildcard_domains = null,
    ) {
    }
}
