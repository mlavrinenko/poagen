<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class IntegrationInstallationRequest
{
    public function __construct(
        public SimpleUser|Enterprise $account,
        public DateTimeImmutable $created_at,
        public int $id,
        public SimpleUser $requester,
        public ?string $node_id = null,
    ) {
    }
}
