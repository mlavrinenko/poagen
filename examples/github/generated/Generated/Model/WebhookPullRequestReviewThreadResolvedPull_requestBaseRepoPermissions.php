<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestReviewThreadResolvedPull_requestBaseRepoPermissions
{
    public function __construct(
        public bool $admin,
        public bool $pull,
        public bool $push,
        public ?bool $maintain = null,
        public ?bool $triage = null,
    ) {
    }
}
