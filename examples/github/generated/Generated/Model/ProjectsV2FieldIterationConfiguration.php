<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use Mlavrinenko\Paogen\Runtime\Attribute\Format;

final readonly class ProjectsV2FieldIterationConfiguration
{
    /**
     * @param ?list<array<string, mixed>> $iterations
     */
    public function __construct(
        public ?int $duration = null,
        public ?array $iterations = null,
        #[Format('date')]
        public ?DateTimeImmutable $start_date = null,
    ) {
    }
}
