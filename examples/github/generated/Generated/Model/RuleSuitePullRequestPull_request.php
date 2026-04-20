<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RuleSuitePullRequestPull_request
{
    /**
     * @param ?list<array<string, mixed>> $reviews
     */
    public function __construct(
        public ?int $id = null,
        public ?int $number = null,
        public ?array $reviews = null,
        public ?RuleSuitePullRequestPull_requestUser $user = null,
    ) {
    }
}
