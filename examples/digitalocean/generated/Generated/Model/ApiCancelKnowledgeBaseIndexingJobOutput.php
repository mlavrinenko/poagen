<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiCancelKnowledgeBaseIndexingJobOutput
{
    public function __construct(
        public ?ApiIndexingJob $job = null,
    ) {
    }
}
