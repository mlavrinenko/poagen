<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class Integration
{
    /**
     * @param list<string> $events
     * @param array<string, string> $permissions
     * @todo Inline object mixes declared properties with additionalProperties; emitted as array<string, mixed>. See T-013 out-of-scope.
     */
    public function __construct(
        public DateTimeImmutable $created_at,
        public ?string $description = null,
        public array $events,
        public string $external_url,
        public string $html_url,
        public int $id,
        public string $name,
        public string $node_id,
        public SimpleUser|Enterprise $owner,
        public array $permissions,
        public DateTimeImmutable $updated_at,
        public ?string $client_id = null,
        public ?int $installations_count = null,
        public ?string $slug = null,
    ) {
    }
}
