<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\AllowedActions;
use Acme\GitHub\Generated\Enum\EnabledRepositories;

final readonly class ActionsOrganizationPermissions
{
    public function __construct(
        public EnabledRepositories $enabled_repositories,
        public ?AllowedActions $allowed_actions = null,
        public ?SelectedActionsUrl $selected_actions_url = null,
        public ?string $selected_repositories_url = null,
        public ?ShaPinningRequired $sha_pinning_required = null,
    ) {
    }
}
