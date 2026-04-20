<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class TimelineCrossReferencedEvent implements TimelineIssueEvents
{
    public function __construct(
        public DateTimeImmutable $created_at,
        public string $event,
        public TimelineCrossReferencedEventSource $source,
        public DateTimeImmutable $updated_at,
        public ?SimpleUser $actor = null,
    ) {
    }
}
