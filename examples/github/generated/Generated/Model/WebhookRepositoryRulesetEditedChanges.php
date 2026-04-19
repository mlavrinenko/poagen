<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookRepositoryRulesetEditedChanges implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'conditions' => ['conditions', \Acme\GitHub\Generated\Model\WebhookRepositoryRulesetEditedChangesConditions::class],
        'enforcement' => [
            'enforcement',
            \Acme\GitHub\Generated\Model\WebhookRepositoryRulesetEditedChangesEnforcement::class,
        ],
        'name' => ['name', \Acme\GitHub\Generated\Model\WebhookRepositoryRulesetEditedChangesName::class],
        'rules' => ['rules', \Acme\GitHub\Generated\Model\WebhookRepositoryRulesetEditedChangesRules::class],
    ];

    public function __construct(
        public ?WebhookRepositoryRulesetEditedChangesConditions $conditions = null,
        public ?WebhookRepositoryRulesetEditedChangesEnforcement $enforcement = null,
        public ?WebhookRepositoryRulesetEditedChangesName $name = null,
        public ?WebhookRepositoryRulesetEditedChangesRules $rules = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'conditions' => $this->conditions,
            'enforcement' => $this->enforcement,
            'name' => $this->name,
            'rules' => $this->rules,
        ];
    }
}
