<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class SelectedActions
{
    /**
     * @param ?list<string> $patterns_allowed
     */
    public function __construct(
        public ?bool $github_owned_allowed = null,
        public ?array $patterns_allowed = null,
        public ?bool $verified_allowed = null,
    ) {
    }
}
