<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CodeSecurityConfigurationForRepository
{
    public function __construct(
        public ?CodeSecurityConfiguration $configuration = null,
        public ?string $status = null,
    ) {
    }
}
