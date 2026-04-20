<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class CommunityProfile
{
    public function __construct(
        public ?string $description = null,
        public ?string $documentation = null,
        public CommunityProfileFiles $files,
        public int $health_percentage,
        public ?DateTimeImmutable $updated_at = null,
        public ?bool $content_reports_enabled = null,
    ) {
    }
}
