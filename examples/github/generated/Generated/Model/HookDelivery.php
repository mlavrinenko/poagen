<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class HookDelivery implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'action' => ['action', null],
        'delivered_at' => ['delivered_at', ['datetime', null]],
        'duration' => ['duration', null],
        'event' => ['event', null],
        'guid' => ['guid', null],
        'id' => ['id', null],
        'installation_id' => ['installation_id', null],
        'redelivery' => ['redelivery', null],
        'repository_id' => ['repository_id', null],
        'request' => ['request', \Acme\GitHub\Generated\Model\HookDeliveryRequest::class],
        'response' => ['response', \Acme\GitHub\Generated\Model\HookDeliveryResponse::class],
        'status' => ['status', null],
        'status_code' => ['status_code', null],
        'throttled_at' => ['throttled_at', ['datetime', null]],
        'url' => ['url', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'action' => $this->action,
            'delivered_at' => $this->delivered_at->format(\DateTimeInterface::RFC3339),
            'duration' => $this->duration,
            'event' => $this->event,
            'guid' => $this->guid,
            'id' => $this->id,
            'installation_id' => $this->installation_id,
            'redelivery' => $this->redelivery,
            'repository_id' => $this->repository_id,
            'request' => $this->request,
            'response' => $this->response,
            'status' => $this->status,
            'status_code' => $this->status_code,
            'throttled_at' => $this->throttled_at?->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
        ];
    }
}
