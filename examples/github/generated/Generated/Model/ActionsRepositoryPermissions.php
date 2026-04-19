<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\AllowedActions;
use JsonSerializable;

final readonly class ActionsRepositoryPermissions implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'enabled' => ['enabled', \Acme\GitHub\Generated\Model\ActionsEnabled::class],
        'allowed_actions' => ['allowed_actions', ['enum', \Acme\GitHub\Generated\Enum\AllowedActions::class]],
        'selected_actions_url' => ['selected_actions_url', \Acme\GitHub\Generated\Model\SelectedActionsUrl::class],
        'sha_pinning_required' => ['sha_pinning_required', \Acme\GitHub\Generated\Model\ShaPinningRequired::class],
    ];

    public function __construct(
        public ActionsEnabled $enabled,
        public ?AllowedActions $allowed_actions = null,
        public ?SelectedActionsUrl $selected_actions_url = null,
        public ?ShaPinningRequired $sha_pinning_required = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'enabled' => $this->enabled,
            'allowed_actions' => $this->allowed_actions,
            'selected_actions_url' => $this->selected_actions_url,
            'sha_pinning_required' => $this->sha_pinning_required,
        ];
    }
}
