<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class DatabaseBackup
{
    public function __construct(
        public string $database_name,
        public ?DateTimeImmutable $backup_created_at = null,
    ) {
    }
}
