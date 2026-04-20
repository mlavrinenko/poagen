<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class MysqlIncrementalBackup
{
    public function __construct(
        public ?bool $enabled = null,
        public ?string $full_backup_week_schedule = null,
    ) {
    }
}
