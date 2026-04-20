<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\AuthorAssociation;
use DateTimeImmutable;

final readonly class PullRequestReview
{
    public function __construct(
        public PullRequestReview_links $_links,
        public AuthorAssociation $author_association,
        public string $body,
        public ?string $commit_id = null,
        public string $html_url,
        public int $id,
        public string $node_id,
        public string $pull_request_url,
        public string $state,
        public NullableSimpleUser $user,
        public ?string $body_html = null,
        public ?string $body_text = null,
        public ?DateTimeImmutable $submitted_at = null,
    ) {
    }
}
