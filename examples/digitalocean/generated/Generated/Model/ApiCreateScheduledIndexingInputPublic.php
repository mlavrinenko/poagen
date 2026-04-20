<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiCreateScheduledIndexingInputPublic
{
    /**
     * @param ?list<int> $days
     */
    public function __construct(
        public ?array $days = null,
        public ?string $knowledge_base_uuid = null,
        public ?string $time = null,
    ) {
    }
}
