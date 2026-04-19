<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookMetaDeletedHook implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'active' => ['active', null],
        'config' => ['config', \Acme\GitHub\Generated\Model\WebhookMetaDeletedHookConfig::class],
        'created_at' => ['created_at', null],
        'events' => ['events', ['list', null]],
        'id' => ['id', null],
        'name' => ['name', null],
        'type' => ['type', null],
        'updated_at' => ['updated_at', null],
    ];

    /**
     * @param list<string> $events
     */
    public function __construct(
        public bool $active,
        public WebhookMetaDeletedHookConfig $config,
        public string $created_at,
        public array $events,
        public int $id,
        public string $name,
        public string $type,
        public string $updated_at,
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
            'created_at' => $this->created_at,
            'events' => $this->events,
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'updated_at' => $this->updated_at,
        ];
    }
}
