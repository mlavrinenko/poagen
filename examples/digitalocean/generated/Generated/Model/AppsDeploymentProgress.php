<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppsDeploymentProgress implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'error_steps' => ['error_steps', null],
        'pending_steps' => ['pending_steps', null],
        'running_steps' => ['running_steps', null],
        'steps' => ['steps', ['list', \Acme\DigitalOcean\Generated\Model\AppsDeploymentProgressStep::class]],
        'success_steps' => ['success_steps', null],
        'summary_steps' => [
            'summary_steps',
            ['list', \Acme\DigitalOcean\Generated\Model\AppsDeploymentProgressStep::class],
        ],
        'total_steps' => ['total_steps', null],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppsDeploymentProgressStep> $steps
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppsDeploymentProgressStep> $summary_steps
     */
    public function __construct(
        public ?int $error_steps = null,
        public ?int $pending_steps = null,
        public ?int $running_steps = null,
        public ?array $steps = null,
        public ?int $success_steps = null,
        public ?array $summary_steps = null,
        public ?int $total_steps = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'error_steps' => $this->error_steps,
            'pending_steps' => $this->pending_steps,
            'running_steps' => $this->running_steps,
            'steps' => $this->steps,
            'success_steps' => $this->success_steps,
            'summary_steps' => $this->summary_steps,
            'total_steps' => $this->total_steps,
        ];
    }
}
