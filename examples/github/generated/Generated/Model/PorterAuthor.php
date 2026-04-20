<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class PorterAuthor
{
    public function __construct(
        public string $email,
        public int $id,
        public string $import_url,
        public string $name,
        public string $remote_id,
        public string $remote_name,
        public string $url,
    ) {
    }
}
