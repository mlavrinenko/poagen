<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\AllowedActions;
use Acme\GitHub\Generated\Enum\EnabledRepositories;
use JsonSerializable;

final readonly class ActionsOrganizationPermissions implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'enabled_repositories' => [
            'enabled_repositories',
            ['enum', \Acme\GitHub\Generated\Enum\EnabledRepositories::class],
        ],
        'allowed_actions' => ['allowed_actions', ['enum', \Acme\GitHub\Generated\Enum\AllowedActions::class]],
        'selected_actions_url' => ['selected_actions_url', \Acme\GitHub\Generated\Model\SelectedActionsUrl::class],
        'selected_repositories_url' => ['selected_repositories_url', null],
        'sha_pinning_required' => ['sha_pinning_required', \Acme\GitHub\Generated\Model\ShaPinningRequired::class],
    ];

    public function __construct(
        public EnabledRepositories $enabled_repositories,
        public ?AllowedActions $allowed_actions = null,
        public ?SelectedActionsUrl $selected_actions_url = null,
        public ?string $selected_repositories_url = null,
        public ?ShaPinningRequired $sha_pinning_required = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'enabled_repositories' => $this->enabled_repositories,
            'allowed_actions' => $this->allowed_actions,
            'selected_actions_url' => $this->selected_actions_url,
            'selected_repositories_url' => $this->selected_repositories_url,
            'sha_pinning_required' => $this->sha_pinning_required,
        ];
    }
}
