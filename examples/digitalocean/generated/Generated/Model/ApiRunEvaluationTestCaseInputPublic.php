<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiRunEvaluationTestCaseInputPublic
{
    /**
     * @param ?list<string> $agent_deployment_names
     * @param ?list<string> $agent_uuids
     */
    public function __construct(
        public ?array $agent_deployment_names = null,
        public ?array $agent_uuids = null,
        public ?string $run_name = null,
        public ?string $test_case_uuid = null,
    ) {
    }
}
