<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookRepositoryRulesetEditedChanges
{
    public function __construct(
        public ?WebhookRepositoryRulesetEditedChangesConditions $conditions = null,
        public ?WebhookRepositoryRulesetEditedChangesEnforcement $enforcement = null,
        public ?WebhookRepositoryRulesetEditedChangesName $name = null,
        public ?WebhookRepositoryRulesetEditedChangesRules $rules = null,
    ) {
    }
}
