<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookCodeScanningAlertClosedByUserAlertRule
{
    /**
     * @param ?list<string> $tags
     */
    public function __construct(
        public string $description,
        public string $id,
        public ?string $severity = null,
        public ?string $full_description = null,
        public ?string $help = null,
        public ?string $help_uri = null,
        public ?string $name = null,
        public ?array $tags = null,
    ) {
    }
}
