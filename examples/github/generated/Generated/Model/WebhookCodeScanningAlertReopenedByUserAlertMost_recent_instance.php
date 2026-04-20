<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookCodeScanningAlertReopenedByUserAlertMost_recent_instance
{
    /**
     * @param ?list<string> $classifications
     */
    public function __construct(
        public string $analysis_key,
        public string $environment,
        public string $ref,
        public string $state,
        public ?string $category = null,
        public ?array $classifications = null,
        public ?string $commit_sha = null,
        public ?WebhookCodeScanningAlertReopenedByUserAlertMost_recent_instanceLocation $location = null,
        public ?WebhookCodeScanningAlertReopenedByUserAlertMost_recent_instanceMessage $message = null,
    ) {
    }
}
