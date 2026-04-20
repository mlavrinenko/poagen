<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class SimpleClassroomOrganization
{
    public function __construct(
        public string $avatar_url,
        public string $html_url,
        public int $id,
        public string $login,
        public ?string $name = null,
        public string $node_id,
    ) {
    }
}
