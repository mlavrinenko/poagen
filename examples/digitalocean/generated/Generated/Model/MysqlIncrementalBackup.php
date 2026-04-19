<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class MysqlIncrementalBackup implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'enabled' => ['enabled', null],
        'full_backup_week_schedule' => ['full_backup_week_schedule', null],
    ];

    public function __construct(
        public ?bool $enabled = null,
        public ?string $full_backup_week_schedule = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'enabled' => $this->enabled,
            'full_backup_week_schedule' => $this->full_backup_week_schedule,
        ];
    }
}
