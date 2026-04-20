<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiGetEvaluationRunResultsOutput
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiPrompt> $prompts
     */
    public function __construct(
        public ?ApiEvaluationRun $evaluation_run = null,
        public ?ApiLinks $links = null,
        public ?ApiMeta $meta = null,
        public ?array $prompts = null,
    ) {
    }
}
