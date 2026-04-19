<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class RepositoryRuleRequiredDeploymentsParameters implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'required_deployment_environments' => ['required_deployment_environments', ['list', null]],
    ];

    /**
     * @param list<string> $required_deployment_environments
     */
    public function __construct(
        public array $required_deployment_environments,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'required_deployment_environments' => $this->required_deployment_environments,
        ];
    }
}
