<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\SecurityAdvisoryCreditTypes;

final readonly class RepositoryAdvisoryCredit
{
    public function __construct(
        public string $state,
        public SecurityAdvisoryCreditTypes $type,
        public SimpleUser $user,
    ) {
    }
}
