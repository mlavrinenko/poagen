<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryCode_search_index_status
{
    public function __construct(
        public ?string $lexical_commit_sha = null,
        public ?bool $lexical_search_ok = null,
    ) {
    }
}
