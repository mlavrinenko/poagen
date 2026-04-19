<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiGetEvaluationRunResultsOutput implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'evaluation_run' => ['evaluation_run', \Acme\DigitalOcean\Generated\Model\ApiEvaluationRun::class],
        'links' => ['links', \Acme\DigitalOcean\Generated\Model\ApiLinks::class],
        'meta' => ['meta', \Acme\DigitalOcean\Generated\Model\ApiMeta::class],
        'prompts' => ['prompts', ['list', \Acme\DigitalOcean\Generated\Model\ApiPrompt::class]],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiPrompt> $prompts
     */
    public function __construct(
        public ?ApiEvaluationRun $evaluation_run = null,
        public ?ApiLinks $links = null,
        public ?ApiMeta $meta = null,
        public ?array $prompts = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'evaluation_run' => $this->evaluation_run,
            'links' => $this->links,
            'meta' => $this->meta,
            'prompts' => $this->prompts,
        ];
    }
}
