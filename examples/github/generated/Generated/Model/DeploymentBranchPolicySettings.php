<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class DeploymentBranchPolicySettings implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'custom_branch_policies' => ['custom_branch_policies', null],
        'protected_branches' => ['protected_branches', null],
    ];

    public function __construct(
        public bool $custom_branch_policies,
        public bool $protected_branches,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'custom_branch_policies' => $this->custom_branch_policies,
            'protected_branches' => $this->protected_branches,
        ];
    }
}
