<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ActionsArtifactAndLogRetentionResponse
{
    public function __construct(
        public int $days,
        public int $maximum_allowed_days,
    ) {
    }
}
