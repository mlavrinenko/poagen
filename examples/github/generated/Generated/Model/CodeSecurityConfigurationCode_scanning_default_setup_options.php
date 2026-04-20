<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CodeSecurityConfigurationCode_scanning_default_setup_options
{
    public function __construct(
        public ?string $runner_label = null,
        public ?string $runner_type = null,
    ) {
    }
}
