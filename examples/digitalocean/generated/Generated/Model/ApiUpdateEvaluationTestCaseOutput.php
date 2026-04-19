<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiUpdateEvaluationTestCaseOutput implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['test_case_uuid' => ['test_case_uuid', null], 'version' => ['version', null]];

    public function __construct(
        public ?string $test_case_uuid = null,
        public ?int $version = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'test_case_uuid' => $this->test_case_uuid,
            'version' => $this->version,
        ];
    }
}
