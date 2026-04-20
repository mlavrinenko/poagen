<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DropletActionChangeBackupPolicy
{
    /**
     * @param ?mixed $backup_policy
     */
    public function __construct(
        public string $type,
        public $backup_policy = null,
    ) {
    }
}
