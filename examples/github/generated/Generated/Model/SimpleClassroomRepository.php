<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class SimpleClassroomRepository
{
    public function __construct(
        public string $default_branch,
        public string $full_name,
        public string $html_url,
        public int $id,
        public string $node_id,
        public bool $private,
    ) {
    }
}
