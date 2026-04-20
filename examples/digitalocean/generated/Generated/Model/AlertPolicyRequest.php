<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AlertPolicyRequest
{
    /**
     * @param list<string> $entities
     * @param list<string> $tags
     */
    public function __construct(
        public Alerts $alerts,
        public string $compare,
        public string $description,
        public bool $enabled,
        public array $entities,
        public array $tags,
        public string $type,
        public float $value,
        public string $window,
    ) {
    }
}
