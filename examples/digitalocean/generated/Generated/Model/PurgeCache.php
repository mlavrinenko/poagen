<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class PurgeCache
{
    /**
     * @param list<string> $files
     */
    public function __construct(
        public array $files,
    ) {
    }
}
