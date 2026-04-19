<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiRunEvaluationTestCaseInputPublic implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'agent_deployment_names' => ['agent_deployment_names', ['list', null]],
        'agent_uuids' => ['agent_uuids', ['list', null]],
        'run_name' => ['run_name', null],
        'test_case_uuid' => ['test_case_uuid', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'agent_deployment_names' => $this->agent_deployment_names,
            'agent_uuids' => $this->agent_uuids,
            'run_name' => $this->run_name,
            'test_case_uuid' => $this->test_case_uuid,
        ];
    }
}
