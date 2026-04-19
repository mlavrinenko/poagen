<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\RepositoryRuleEnforcement;
use DateTimeImmutable;
use JsonSerializable;

final readonly class RepositoryRuleset implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'enforcement' => ['enforcement', ['enum', \Acme\GitHub\Generated\Enum\RepositoryRuleEnforcement::class]],
        'id' => ['id', null],
        'name' => ['name', null],
        'source' => ['source', null],
        '_links' => ['_links', \Acme\GitHub\Generated\Model\RepositoryRuleset_links::class],
        'bypass_actors' => ['bypass_actors', ['list', \Acme\GitHub\Generated\Model\RepositoryRulesetBypassActor::class]],
        'conditions' => [
            'conditions',
            [
                'union',
                [
                    \Acme\GitHub\Generated\Model\RepositoryRulesetConditions::class,
                    \Acme\GitHub\Generated\Model\OrgRulesetConditions::class,
                ],
                null,
            ],
        ],
        'created_at' => ['created_at', ['datetime', null]],
        'current_user_can_bypass' => ['current_user_can_bypass', null],
        'node_id' => ['node_id', null],
        'rules' => ['rules', ['list', \Acme\GitHub\Generated\Model\RepositoryRule::class]],
        'source_type' => ['source_type', null],
        'target' => ['target', null],
        'updated_at' => ['updated_at', ['datetime', null]],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'enforcement' => $this->enforcement,
            'id' => $this->id,
            'name' => $this->name,
            'source' => $this->source,
            '_links' => $this->_links,
            'bypass_actors' => $this->bypass_actors,
            'conditions' => $this->conditions,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'current_user_can_bypass' => $this->current_user_can_bypass,
            'node_id' => $this->node_id,
            'rules' => $this->rules,
            'source_type' => $this->source_type,
            'target' => $this->target,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
        ];
    }
}
