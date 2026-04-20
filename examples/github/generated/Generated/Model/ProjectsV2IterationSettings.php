<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use Mlavrinenko\Paogen\Runtime\Attribute\Format;

final readonly class ProjectsV2IterationSettings
{
    public function __construct(
        public bool $completed,
        public int $duration,
        public string $id,
        #[Format('date')]
        public DateTimeImmutable $start_date,
        public ProjectsV2IterationSettingsTitle $title,
    ) {
    }
}
