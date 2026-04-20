<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class CodespacesSecret
{
    public function __construct(
        public DateTimeImmutable $created_at,
        public string $name,
        public string $selected_repositories_url,
        public DateTimeImmutable $updated_at,
        public string $visibility,
    ) {
    }
}
