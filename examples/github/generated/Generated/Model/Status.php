<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class Status
{
    public function __construct(
        public ?string $avatar_url = null,
        public string $context,
        public string $created_at,
        public NullableSimpleUser $creator,
        public ?string $description = null,
        public int $id,
        public string $node_id,
        public string $state,
        public ?string $target_url = null,
        public string $updated_at,
        public string $url,
    ) {
    }
}
