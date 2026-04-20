<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class HookDeliveryRequest
{
    /**
     * @param ?array<string, mixed> $headers
     * @param ?array<string, mixed> $payload
     */
    public function __construct(
        public ?array $headers = null,
        public ?array $payload = null,
    ) {
    }
}
