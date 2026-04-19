<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class CheckRunWithSimpleCheckSuite implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'app' => ['app', \Acme\GitHub\Generated\Model\Integration::class],
        'check_suite' => ['check_suite', \Acme\GitHub\Generated\Model\SimpleCheckSuite::class],
        'completed_at' => ['completed_at', ['datetime', null]],
        'conclusion' => ['conclusion', null],
        'details_url' => ['details_url', null],
        'external_id' => ['external_id', null],
        'head_sha' => ['head_sha', null],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'name' => ['name', null],
        'node_id' => ['node_id', null],
        'output' => ['output', \Acme\GitHub\Generated\Model\CheckRunWithSimpleCheckSuiteOutput::class],
        'pull_requests' => ['pull_requests', ['list', \Acme\GitHub\Generated\Model\PullRequestMinimal::class]],
        'started_at' => ['started_at', ['datetime', null]],
        'status' => ['status', null],
        'url' => ['url', null],
        'deployment' => ['deployment', \Acme\GitHub\Generated\Model\DeploymentSimple::class],
    ];

    /**
     * @param list<\Acme\GitHub\Generated\Model\PullRequestMinimal> $pull_requests
     */
    public function __construct(
        public Integration $app,
        public SimpleCheckSuite $check_suite,
        public ?DateTimeImmutable $completed_at = null,
        public ?string $conclusion = null,
        public string $details_url,
        public string $external_id,
        public string $head_sha,
        public string $html_url,
        public int $id,
        public string $name,
        public string $node_id,
        public CheckRunWithSimpleCheckSuiteOutput $output,
        public array $pull_requests,
        public DateTimeImmutable $started_at,
        public string $status,
        public string $url,
        public ?DeploymentSimple $deployment = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'app' => $this->app,
            'check_suite' => $this->check_suite,
            'completed_at' => $this->completed_at?->format(\DateTimeInterface::RFC3339),
            'conclusion' => $this->conclusion,
            'details_url' => $this->details_url,
            'external_id' => $this->external_id,
            'head_sha' => $this->head_sha,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'name' => $this->name,
            'node_id' => $this->node_id,
            'output' => $this->output,
            'pull_requests' => $this->pull_requests,
            'started_at' => $this->started_at->format(\DateTimeInterface::RFC3339),
            'status' => $this->status,
            'url' => $this->url,
            'deployment' => $this->deployment,
        ];
    }
}
