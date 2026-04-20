<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class ApiWorkspace
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiAgent> $agents
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiEvaluationTestCase> $evaluation_test_cases
     */
    public function __construct(
        public ?array $agents = null,
        public ?DateTimeImmutable $created_at = null,
        public ?string $created_by = null,
        public ?string $created_by_email = null,
        public ?DateTimeImmutable $deleted_at = null,
        public ?string $description = null,
        public ?array $evaluation_test_cases = null,
        public ?string $name = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?string $uuid = null,
    ) {
    }
}
