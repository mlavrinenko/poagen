<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class IssueField
{
    /**
     * @param ?list<array<string, mixed>> $options
     */
    public function __construct(
        public string $data_type,
        public int $id,
        public string $name,
        public string $node_id,
        public ?DateTimeImmutable $created_at = null,
        public ?string $description = null,
        public ?array $options = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?string $visibility = null,
    ) {
    }
}
