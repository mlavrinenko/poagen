<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiListKnowledgeBaseIndexingJobsOutput
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiIndexingJob> $jobs
     */
    public function __construct(
        public ?array $jobs = null,
        public ?ApiLinks $links = null,
        public ?ApiMeta $meta = null,
    ) {
    }
}
