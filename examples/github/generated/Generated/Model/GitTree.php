<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class GitTree
{
    /**
     * @param list<array<string, mixed>> $tree
     */
    public function __construct(
        public string $sha,
        public array $tree,
        public bool $truncated,
        public ?string $url = null,
    ) {
    }
}
