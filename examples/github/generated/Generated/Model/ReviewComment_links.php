<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ReviewComment_links
{
    public function __construct(
        public Link $html,
        public Link $pull_request,
        public Link $self,
    ) {
    }
}
