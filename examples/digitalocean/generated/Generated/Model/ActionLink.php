<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ActionLink
{
    public function __construct(
        public ?string $href = null,
        public ?int $id = null,
        public ?string $rel = null,
    ) {
    }
}
