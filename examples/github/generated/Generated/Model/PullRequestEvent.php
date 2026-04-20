<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class PullRequestEvent
{
    /**
     * @param ?list<\Acme\GitHub\Generated\Model\SimpleUser> $assignees
     * @param ?list<\Acme\GitHub\Generated\Model\Label> $labels
     */
    public function __construct(
        public string $action,
        public int $number,
        public PullRequestMinimal $pull_request,
        public ?SimpleUser $assignee = null,
        public ?array $assignees = null,
        public ?Label $label = null,
        public ?array $labels = null,
    ) {
    }
}
