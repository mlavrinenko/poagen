<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class DatabaseBackup implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'database_name' => ['database_name', null],
        'backup_created_at' => ['backup_created_at', ['datetime', null]],
    ];

    public function __construct(
        public string $database_name,
        public ?DateTimeImmutable $backup_created_at = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'database_name' => $this->database_name,
            'backup_created_at' => $this->backup_created_at?->format(\DateTimeInterface::RFC3339),
        ];
    }
}
