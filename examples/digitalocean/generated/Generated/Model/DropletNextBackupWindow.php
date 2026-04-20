<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class DropletNextBackupWindow
{
    public function __construct(
        public ?DateTimeImmutable $end = null,
        public ?DateTimeImmutable $start = null,
    ) {
    }
}
