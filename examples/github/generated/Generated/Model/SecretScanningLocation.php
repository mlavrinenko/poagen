<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class SecretScanningLocation
{
    public function __construct(
        public SecretScanningLocationCommit|SecretScanningLocationWikiCommit|SecretScanningLocationIssueTitle|SecretScanningLocationIssueBody|SecretScanningLocationIssueComment|SecretScanningLocationDiscussionTitle|SecretScanningLocationDiscussionBody|SecretScanningLocationDiscussionComment|SecretScanningLocationPullRequestTitle|SecretScanningLocationPullRequestBody|SecretScanningLocationPullRequestComment|SecretScanningLocationPullRequestReview|SecretScanningLocationPullRequestReviewComment|null $details = null,
        public ?string $type = null,
    ) {
    }
}
