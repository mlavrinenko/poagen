<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AddonsAppInfo
{
    /**
     * @param list<\Acme\DigitalOcean\Generated\Model\AddonsPlan> $plans
     */
    public function __construct(
        public string $app_slug,
        public string $eula,
        public array $plans,
        public string $tos,
    ) {
    }
}
