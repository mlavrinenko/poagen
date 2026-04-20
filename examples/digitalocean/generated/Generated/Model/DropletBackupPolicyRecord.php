<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DropletBackupPolicyRecord
{
    /**
     * @param ?mixed $backup_policy
     * @param ?mixed $next_backup_window
     */
    public function __construct(
        public ?bool $backup_enabled = null,
        public $backup_policy = null,
        public ?int $droplet_id = null,
        public $next_backup_window = null,
    ) {
    }
}
