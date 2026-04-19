<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiGetEvaluationRunOutput implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'evaluation_run' => ['evaluation_run', \Acme\DigitalOcean\Generated\Model\ApiEvaluationRun::class],
    ];

    public function __construct(
        public ?ApiEvaluationRun $evaluation_run = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'evaluation_run' => $this->evaluation_run,
        ];
    }
}
