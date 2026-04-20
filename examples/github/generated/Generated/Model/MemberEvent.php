<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class MemberEvent
{
    public function __construct(
        public string $action,
        public SimpleUser $member,
    ) {
    }
}
