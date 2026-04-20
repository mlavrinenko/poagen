<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class Tag
{
    public function __construct(
        public TagCommit $commit,
        public string $name,
        public string $node_id,
        public string $tarball_url,
        public string $zipball_url,
    ) {
    }
}
