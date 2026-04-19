<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiListEvaluationTestCasesOutput implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'evaluation_test_cases' => [
            'evaluation_test_cases',
            ['list', \Acme\DigitalOcean\Generated\Model\ApiEvaluationTestCase::class],
        ],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiEvaluationTestCase> $evaluation_test_cases
     */
    public function __construct(
        public ?array $evaluation_test_cases = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'evaluation_test_cases' => $this->evaluation_test_cases,
        ];
    }
}
