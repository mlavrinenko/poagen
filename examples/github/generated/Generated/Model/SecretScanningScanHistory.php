<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class SecretScanningScanHistory implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'backfill_scans' => ['backfill_scans', ['list', \Acme\GitHub\Generated\Model\SecretScanningScan::class]],
        'custom_pattern_backfill_scans' => ['custom_pattern_backfill_scans', ['list', null]],
        'generic_secrets_backfill_scans' => [
            'generic_secrets_backfill_scans',
            ['list', \Acme\GitHub\Generated\Model\SecretScanningScan::class],
        ],
        'incremental_scans' => ['incremental_scans', ['list', \Acme\GitHub\Generated\Model\SecretScanningScan::class]],
        'pattern_update_scans' => [
            'pattern_update_scans',
            ['list', \Acme\GitHub\Generated\Model\SecretScanningScan::class],
        ],
    ];

    /**
     * @param ?list<\Acme\GitHub\Generated\Model\SecretScanningScan> $backfill_scans
     * @param ?list<mixed> $custom_pattern_backfill_scans
     * @param ?list<\Acme\GitHub\Generated\Model\SecretScanningScan> $generic_secrets_backfill_scans
     * @param ?list<\Acme\GitHub\Generated\Model\SecretScanningScan> $incremental_scans
     * @param ?list<\Acme\GitHub\Generated\Model\SecretScanningScan> $pattern_update_scans
     */
    public function __construct(
        public ?array $backfill_scans = null,
        public ?array $custom_pattern_backfill_scans = null,
        public ?array $generic_secrets_backfill_scans = null,
        public ?array $incremental_scans = null,
        public ?array $pattern_update_scans = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'backfill_scans' => $this->backfill_scans,
            'custom_pattern_backfill_scans' => $this->custom_pattern_backfill_scans,
            'generic_secrets_backfill_scans' => $this->generic_secrets_backfill_scans,
            'incremental_scans' => $this->incremental_scans,
            'pattern_update_scans' => $this->pattern_update_scans,
        ];
    }
}
