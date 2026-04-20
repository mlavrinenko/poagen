<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ActionsHostedRunnerCustomImage
{
    public function __construct(
        public int $id,
        public string $latest_version,
        public string $name,
        public string $platform,
        public string $source,
        public string $state,
        public int $total_versions_size,
        public int $versions_count,
    ) {
    }
}
