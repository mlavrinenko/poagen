<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\RepositoryRuleEnforcement;
use DateTimeImmutable;

final readonly class RepositoryRuleset
{
    /**
     * @param ?list<\Acme\GitHub\Generated\Model\RepositoryRulesetBypassActor> $bypass_actors
     * @param ?list<\Acme\GitHub\Generated\Model\RepositoryRule> $rules
     */
    public function __construct(
        public RepositoryRuleEnforcement $enforcement,
        public int $id,
        public string $name,
        public string $source,
        public ?RepositoryRuleset_links $_links = null,
        public ?array $bypass_actors = null,
        public RepositoryRulesetConditions|OrgRulesetConditions|null $conditions = null,
        public ?DateTimeImmutable $created_at = null,
        public ?string $current_user_can_bypass = null,
        public ?string $node_id = null,
        public ?array $rules = null,
        public ?string $source_type = null,
        public ?string $target = null,
        public ?DateTimeImmutable $updated_at = null,
    ) {
    }
}
