<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class SourceDatabase
{
    /**
     * @param ?list<string> $ignore_dbs
     */
    public function __construct(
        public SourceDatabaseSource $source,
        public ?bool $disable_ssl = null,
        public ?array $ignore_dbs = null,
    ) {
    }
}
