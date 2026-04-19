<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class RuleSuite implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'actor_id' => ['actor_id', null],
        'actor_name' => ['actor_name', null],
        'after_sha' => ['after_sha', null],
        'before_sha' => ['before_sha', null],
        'evaluation_result' => ['evaluation_result', null],
        'id' => ['id', null],
        'pushed_at' => ['pushed_at', ['datetime', null]],
        'ref' => ['ref', null],
        'repository_id' => ['repository_id', null],
        'repository_name' => ['repository_name', null],
        'result' => ['result', null],
        'rule_evaluations' => ['rule_evaluations', ['list', null]],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'actor_id' => $this->actor_id,
            'actor_name' => $this->actor_name,
            'after_sha' => $this->after_sha,
            'before_sha' => $this->before_sha,
            'evaluation_result' => $this->evaluation_result,
            'id' => $this->id,
            'pushed_at' => $this->pushed_at?->format(\DateTimeInterface::RFC3339),
            'ref' => $this->ref,
            'repository_id' => $this->repository_id,
            'repository_name' => $this->repository_name,
            'result' => $this->result,
            'rule_evaluations' => $this->rule_evaluations,
        ];
    }
}
