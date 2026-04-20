<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class RepositoryInvitation
{
    public function __construct(
        public DateTimeImmutable $created_at,
        public string $html_url,
        public int $id,
        public NullableSimpleUser $invitee,
        public NullableSimpleUser $inviter,
        public string $node_id,
        public string $permissions,
        public MinimalRepository $repository,
        public string $url,
        public ?bool $expired = null,
    ) {
    }
}
