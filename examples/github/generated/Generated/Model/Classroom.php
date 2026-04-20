<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class Classroom
{
    public function __construct(
        public bool $archived,
        public int $id,
        public string $name,
        public SimpleClassroomOrganization $organization,
        public string $url,
    ) {
    }
}
