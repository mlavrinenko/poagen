<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class Autolink
{
    public function __construct(
        public int $id,
        public bool $is_alphanumeric,
        public string $key_prefix,
        public string $url_template,
        public ?DateTimeImmutable $updated_at = null,
    ) {
    }
}
