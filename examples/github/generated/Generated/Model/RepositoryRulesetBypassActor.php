<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRulesetBypassActor
{
    public function __construct(
        public string $actor_type,
        public ?int $actor_id = null,
        public ?string $bypass_mode = null,
    ) {
    }
}
