<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use Mlavrinenko\Paogen\Runtime\Attribute\Format;

final readonly class ProjectsV2StatusUpdate
{
    public function __construct(
        public DateTimeImmutable $created_at,
        public float $id,
        public string $node_id,
        public DateTimeImmutable $updated_at,
        public ?string $body = null,
        public ?SimpleUser $creator = null,
        public ?string $project_node_id = null,
        #[Format('date')]
        public ?DateTimeImmutable $start_date = null,
        public ?string $status = null,
        #[Format('date')]
        public ?DateTimeImmutable $target_date = null,
    ) {
    }
}
