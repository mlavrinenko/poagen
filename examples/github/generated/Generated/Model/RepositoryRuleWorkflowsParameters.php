<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class RepositoryRuleWorkflowsParameters implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'workflows' => [
            'workflows',
            ['list', \Acme\GitHub\Generated\Model\RepositoryRuleParamsWorkflowFileReference::class],
        ],
        'do_not_enforce_on_create' => ['do_not_enforce_on_create', null],
    ];

    /**
     * @param list<\Acme\GitHub\Generated\Model\RepositoryRuleParamsWorkflowFileReference> $workflows
     */
    public function __construct(
        public array $workflows,
        public ?bool $do_not_enforce_on_create = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'workflows' => $this->workflows,
            'do_not_enforce_on_create' => $this->do_not_enforce_on_create,
        ];
    }
}
