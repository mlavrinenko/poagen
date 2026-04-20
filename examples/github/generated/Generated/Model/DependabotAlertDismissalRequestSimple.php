<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class DependabotAlertDismissalRequestSimple
{
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?int $id = null,
        public ?DependabotAlertDismissalRequestSimpleRequester $requester = null,
        public ?string $status = null,
        public ?string $url = null,
    ) {
    }
}
