<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class RuleSuite
{
    /**
     * @param ?list<array<string, mixed>> $rule_evaluations
     */
    public function __construct(
        public ?int $actor_id = null,
        public ?string $actor_name = null,
        public ?string $after_sha = null,
        public ?string $before_sha = null,
        public ?string $evaluation_result = null,
        public ?int $id = null,
        public ?DateTimeImmutable $pushed_at = null,
        public ?string $ref = null,
        public ?int $repository_id = null,
        public ?string $repository_name = null,
        public ?string $result = null,
        public ?array $rule_evaluations = null,
    ) {
    }
}
