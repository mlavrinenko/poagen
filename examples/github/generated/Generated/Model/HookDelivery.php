<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class HookDelivery
{
    public function __construct(
        public ?string $action = null,
        public DateTimeImmutable $delivered_at,
        public float $duration,
        public string $event,
        public string $guid,
        public int $id,
        public ?int $installation_id = null,
        public bool $redelivery,
        public ?int $repository_id = null,
        public HookDeliveryRequest $request,
        public HookDeliveryResponse $response,
        public string $status,
        public int $status_code,
        public ?DateTimeImmutable $throttled_at = null,
        public ?string $url = null,
    ) {
    }
}
