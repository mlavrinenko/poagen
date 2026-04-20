<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class NullableCodespaceMachine
{
    public function __construct(
        public int $cpus,
        public string $display_name,
        public int $memory_in_bytes,
        public string $name,
        public string $operating_system,
        public ?string $prebuild_availability = null,
        public int $storage_in_bytes,
    ) {
    }
}
