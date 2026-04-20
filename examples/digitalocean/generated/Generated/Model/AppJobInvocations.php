<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppJobInvocations
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppJobInvocation> $job_invocations
     */
    public function __construct(
        public ?array $job_invocations = null,
        public ?PageLinks $links = null,
    ) {
    }
}
