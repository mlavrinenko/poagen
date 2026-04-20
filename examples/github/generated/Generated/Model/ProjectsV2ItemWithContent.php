<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\ProjectsV2ItemContentType;
use DateTimeImmutable;

final readonly class ProjectsV2ItemWithContent
{
    /**
     * @param ?array<string, mixed> $content
     * @param ?list<array<string, mixed>> $fields
     */
    public function __construct(
        public ?DateTimeImmutable $archived_at = null,
        public ProjectsV2ItemContentType $content_type,
        public DateTimeImmutable $created_at,
        public float $id,
        public DateTimeImmutable $updated_at,
        public ?array $content = null,
        public ?SimpleUser $creator = null,
        public ?array $fields = null,
        public ?string $item_url = null,
        public ?string $node_id = null,
        public ?string $project_url = null,
    ) {
    }
}
