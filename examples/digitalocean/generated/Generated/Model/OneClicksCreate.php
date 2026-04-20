<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class OneClicksCreate
{
    /**
     * @param list<string> $addon_slugs
     */
    public function __construct(
        public array $addon_slugs,
        public string $cluster_uuid,
    ) {
    }
}
