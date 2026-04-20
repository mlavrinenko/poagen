<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CodeSecurityConfigurationRepositories
{
    public function __construct(
        public ?SimpleRepository $repository = null,
        public ?string $status = null,
    ) {
    }
}
