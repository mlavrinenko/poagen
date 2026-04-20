<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class HookDeliveryResponse
{
    /**
     * @param ?array<string, mixed> $headers
     */
    public function __construct(
        public ?array $headers = null,
        public ?string $payload = null,
    ) {
    }
}
