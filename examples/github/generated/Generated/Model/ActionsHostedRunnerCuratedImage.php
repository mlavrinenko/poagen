<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ActionsHostedRunnerCuratedImage
{
    public function __construct(
        public string $display_name,
        public string $id,
        public string $platform,
        public int $size_gb,
        public string $source,
    ) {
    }
}
