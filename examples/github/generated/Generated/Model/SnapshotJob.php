<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class SnapshotJob
{
    public function __construct(
        public string $correlator,
        public string $id,
        public ?string $html_url = null,
    ) {
    }
}
