<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class Runner implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'busy' => ['busy', null],
        'id' => ['id', null],
        'labels' => ['labels', ['list', \Acme\GitHub\Generated\Model\RunnerLabel::class]],
        'name' => ['name', null],
        'os' => ['os', null],
        'status' => ['status', null],
        'ephemeral' => ['ephemeral', null],
        'runner_group_id' => ['runner_group_id', null],
    ];

    /**
     * @param list<\Acme\GitHub\Generated\Model\RunnerLabel> $labels
     */
    public function __construct(
        public bool $busy,
        public int $id,
        public array $labels,
        public string $name,
        public string $os,
        public string $status,
        public ?bool $ephemeral = null,
        public ?int $runner_group_id = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'busy' => $this->busy,
            'id' => $this->id,
            'labels' => $this->labels,
            'name' => $this->name,
            'os' => $this->os,
            'status' => $this->status,
            'ephemeral' => $this->ephemeral,
            'runner_group_id' => $this->runner_group_id,
        ];
    }
}
