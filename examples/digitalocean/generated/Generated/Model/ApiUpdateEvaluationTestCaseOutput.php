<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiUpdateEvaluationTestCaseOutput
{
    public function __construct(
        public ?string $test_case_uuid = null,
        public ?int $version = null,
    ) {
    }
}
