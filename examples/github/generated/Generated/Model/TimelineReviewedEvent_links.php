<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class TimelineReviewedEvent_links
{
    public function __construct(
        public TimelineReviewedEvent_linksHtml $html,
        public TimelineReviewedEvent_linksPull_request $pull_request,
    ) {
    }
}
