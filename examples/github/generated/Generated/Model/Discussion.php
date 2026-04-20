<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class Discussion
{
    /**
     * @param ?list<\Acme\GitHub\Generated\Model\Label> $labels
     */
    public function __construct(
        public ?string $active_lock_reason = null,
        public ?string $answer_chosen_at = null,
        public DiscussionAnswer_chosen_by $answer_chosen_by,
        public ?string $answer_html_url = null,
        public string $body,
        public DiscussionCategory $category,
        public int $comments,
        public DateTimeImmutable $created_at,
        public string $html_url,
        public int $id,
        public bool $locked,
        public string $node_id,
        public int $number,
        public string $repository_url,
        public string $state,
        public ?string $state_reason = null,
        public string $title,
        public DateTimeImmutable $updated_at,
        public DiscussionUser $user,
        public ?string $author_association = null,
        public ?array $labels = null,
        public ?DiscussionReactions $reactions = null,
        public ?string $timeline_url = null,
    ) {
    }
}
