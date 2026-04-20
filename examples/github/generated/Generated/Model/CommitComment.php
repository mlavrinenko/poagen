<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\AuthorAssociation;
use DateTimeImmutable;

final readonly class CommitComment
{
    public function __construct(
        public AuthorAssociation $author_association,
        public string $body,
        public string $commit_id,
        public DateTimeImmutable $created_at,
        public string $html_url,
        public int $id,
        public ?int $line = null,
        public string $node_id,
        public ?string $path = null,
        public ?int $position = null,
        public DateTimeImmutable $updated_at,
        public string $url,
        public NullableSimpleUser $user,
        public ?ReactionRollup $reactions = null,
    ) {
    }
}
