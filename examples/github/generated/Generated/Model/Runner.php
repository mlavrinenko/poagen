<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class Runner
{
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
}
