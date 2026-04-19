<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Environment implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'name' => ['name', null],
        'node_id' => ['node_id', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'deployment_branch_policy' => [
            'deployment_branch_policy',
            \Acme\GitHub\Generated\Model\DeploymentBranchPolicySettings::class,
        ],
        'protection_rules' => ['protection_rules', ['list', null]],
    ];

    /**
     * @param ?list<mixed> $protection_rules
     */
    public function __construct(
        public DateTimeImmutable $created_at,
        public string $html_url,
        public int $id,
        public string $name,
        public string $node_id,
        public DateTimeImmutable $updated_at,
        public string $url,
        public ?DeploymentBranchPolicySettings $deployment_branch_policy = null,
        public ?array $protection_rules = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'html_url' => $this->html_url,
            'id' => $this->id,
            'name' => $this->name,
            'node_id' => $this->node_id,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'deployment_branch_policy' => $this->deployment_branch_policy,
            'protection_rules' => $this->protection_rules,
        ];
    }
}
