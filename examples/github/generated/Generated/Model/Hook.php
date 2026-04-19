<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Hook implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'active' => ['active', null],
        'config' => ['config', \Acme\GitHub\Generated\Model\WebhookConfig::class],
        'created_at' => ['created_at', ['datetime', null]],
        'events' => ['events', ['list', null]],
        'id' => ['id', null],
        'last_response' => ['last_response', \Acme\GitHub\Generated\Model\HookResponse::class],
        'name' => ['name', null],
        'ping_url' => ['ping_url', null],
        'test_url' => ['test_url', null],
        'type' => ['type', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'deliveries_url' => ['deliveries_url', null],
    ];

    /**
     * @param list<string> $events
     */
    public function __construct(
        public bool $active,
        public WebhookConfig $config,
        public DateTimeImmutable $created_at,
        public array $events,
        public int $id,
        public HookResponse $last_response,
        public string $name,
        public string $ping_url,
        public string $test_url,
        public string $type,
        public DateTimeImmutable $updated_at,
        public string $url,
        public ?string $deliveries_url = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'active' => $this->active,
            'config' => $this->config,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'events' => $this->events,
            'id' => $this->id,
            'last_response' => $this->last_response,
            'name' => $this->name,
            'ping_url' => $this->ping_url,
            'test_url' => $this->test_url,
            'type' => $this->type,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'deliveries_url' => $this->deliveries_url,
        ];
    }
}
