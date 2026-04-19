<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class DropletBackupPolicyRecord implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'backup_enabled' => ['backup_enabled', null],
        'backup_policy' => ['backup_policy', null],
        'droplet_id' => ['droplet_id', null],
        'next_backup_window' => ['next_backup_window', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'backup_enabled' => $this->backup_enabled,
            'backup_policy' => $this->backup_policy,
            'droplet_id' => $this->droplet_id,
            'next_backup_window' => $this->next_backup_window,
        ];
    }
}
