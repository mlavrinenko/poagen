<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ThreadSubject
{
    public function __construct(
        public string $latest_comment_url,
        public string $title,
        public string $type,
        public string $url,
    ) {
    }
}
