<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ImmutableReleasesOrganizationSettings
{
    public function __construct(
        public string $enforced_repositories,
        public ?string $selected_repositories_url = null,
    ) {
    }
}
