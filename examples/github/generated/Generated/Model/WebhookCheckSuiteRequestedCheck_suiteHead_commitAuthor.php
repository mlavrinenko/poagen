<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhookCheckSuiteRequestedCheck_suiteHead_commitAuthor
{
    public function __construct(
        public ?string $email = null,
        public string $name,
        public ?DateTimeImmutable $date = null,
        public ?string $username = null,
    ) {
    }
}
