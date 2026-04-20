<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\AuthorAssociation;
use DateTimeImmutable;

final readonly class GistComment
{
    public function __construct(
        public AuthorAssociation $author_association,
        public string $body,
        public DateTimeImmutable $created_at,
        public int $id,
        public string $node_id,
        public DateTimeImmutable $updated_at,
        public string $url,
        public NullableSimpleUser $user,
    ) {
    }
}
