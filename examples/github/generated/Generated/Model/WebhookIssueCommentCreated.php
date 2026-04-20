<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookIssueCommentCreated
{
    /**
     * @param mixed $issue
     */
    public function __construct(
        public string $action,
        public WebhookIssueCommentCreatedComment $comment,
        public $issue,
        public RepositoryWebhooks $repository,
        public SimpleUser $sender,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
    ) {
    }
}
