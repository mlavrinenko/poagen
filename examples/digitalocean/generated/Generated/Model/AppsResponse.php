<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppsResponse
{
    /**
     * @param mixed $meta
     * @param ?list<\Acme\DigitalOcean\Generated\Model\App> $apps
     */
    public function __construct(
        public $meta,
        public ?array $apps = null,
        public ?PageLinks $links = null,
    ) {
    }
}
