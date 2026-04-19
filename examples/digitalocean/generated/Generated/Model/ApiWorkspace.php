<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class ApiWorkspace implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'agents' => ['agents', ['list', \Acme\DigitalOcean\Generated\Model\ApiAgent::class]],
        'created_at' => ['created_at', ['datetime', null]],
        'created_by' => ['created_by', null],
        'created_by_email' => ['created_by_email', null],
        'deleted_at' => ['deleted_at', ['datetime', null]],
        'description' => ['description', null],
        'evaluation_test_cases' => [
            'evaluation_test_cases',
            ['list', \Acme\DigitalOcean\Generated\Model\ApiEvaluationTestCase::class],
        ],
        'name' => ['name', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'uuid' => ['uuid', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'agents' => $this->agents,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'created_by' => $this->created_by,
            'created_by_email' => $this->created_by_email,
            'deleted_at' => $this->deleted_at?->format(\DateTimeInterface::RFC3339),
            'description' => $this->description,
            'evaluation_test_cases' => $this->evaluation_test_cases,
            'name' => $this->name,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
            'uuid' => $this->uuid,
        ];
    }
}
