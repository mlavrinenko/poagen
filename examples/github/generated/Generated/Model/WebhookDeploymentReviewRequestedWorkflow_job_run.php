<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookDeploymentReviewRequestedWorkflow_job_run
{
    /**
     * @param ?mixed $conclusion
     */
    public function __construct(
        public $conclusion = null,
        public string $created_at,
        public string $environment,
        public string $html_url,
        public int $id,
        public ?string $name = null,
        public string $status,
        public string $updated_at,
    ) {
    }
}
