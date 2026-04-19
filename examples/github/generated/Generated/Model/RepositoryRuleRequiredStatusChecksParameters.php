<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class RepositoryRuleRequiredStatusChecksParameters implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'required_status_checks' => [
            'required_status_checks',
            ['list', \Acme\GitHub\Generated\Model\RepositoryRuleParamsStatusCheckConfiguration::class],
        ],
        'strict_required_status_checks_policy' => ['strict_required_status_checks_policy', null],
        'do_not_enforce_on_create' => ['do_not_enforce_on_create', null],
    ];

    /**
     * @param list<\Acme\GitHub\Generated\Model\RepositoryRuleParamsStatusCheckConfiguration> $required_status_checks
     */
    public function __construct(
        public array $required_status_checks,
        public bool $strict_required_status_checks_policy,
        public ?bool $do_not_enforce_on_create = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'required_status_checks' => $this->required_status_checks,
            'strict_required_status_checks_policy' => $this->strict_required_status_checks_policy,
            'do_not_enforce_on_create' => $this->do_not_enforce_on_create,
        ];
    }
}
