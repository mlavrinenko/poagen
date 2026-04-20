<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class KubernetesNodePoolTaint
{
    public function __construct(
        public ?string $effect = null,
        public ?string $key = null,
        public ?string $value = null,
    ) {
    }
}
