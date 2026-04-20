<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\AllowedActions;

final readonly class ActionsRepositoryPermissions
{
    public function __construct(
        public ActionsEnabled $enabled,
        public ?AllowedActions $allowed_actions = null,
        public ?SelectedActionsUrl $selected_actions_url = null,
        public ?ShaPinningRequired $sha_pinning_required = null,
    ) {
    }
}
