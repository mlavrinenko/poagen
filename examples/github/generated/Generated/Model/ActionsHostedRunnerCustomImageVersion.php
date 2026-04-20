<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ActionsHostedRunnerCustomImageVersion
{
    public function __construct(
        public string $created_on,
        public int $size_gb,
        public string $state,
        public string $state_details,
        public string $version,
    ) {
    }
}
