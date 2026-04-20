<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class SelfHostedRunnersSettings
{
    public function __construct(
        public string $enabled_repositories,
        public ?string $selected_repositories_url = null,
    ) {
    }
}
