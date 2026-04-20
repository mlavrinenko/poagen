<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookGithubAppAuthorizationRevoked
{
    public function __construct(
        public string $action,
        public SimpleUser $sender,
    ) {
    }
}
