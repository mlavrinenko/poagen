<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ActionsHostedRunnerMachineSpec
{
    public function __construct(
        public int $cpu_cores,
        public string $id,
        public int $memory_gb,
        public int $storage_gb,
    ) {
    }
}
