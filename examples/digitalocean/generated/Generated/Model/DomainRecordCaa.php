<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class DomainRecordCaa implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'data' => ['data', null],
        'flags' => ['flags', null],
        'name' => ['name', null],
        'tag' => ['tag', null],
        'type' => ['type', null],
        'id' => ['id', null],
        'port' => ['port', null],
        'priority' => ['priority', null],
        'ttl' => ['ttl', null],
        'weight' => ['weight', null],
    ];

    public function __construct(
        public string $data,
        public ?int $flags = null,
        public string $name,
        public ?string $tag = null,
        public string $type,
        public ?int $id = null,
        public ?int $port = null,
        public ?int $priority = null,
        public ?int $ttl = null,
        public ?int $weight = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'data' => $this->data,
            'flags' => $this->flags,
            'name' => $this->name,
            'tag' => $this->tag,
            'type' => $this->type,
            'id' => $this->id,
            'port' => $this->port,
            'priority' => $this->priority,
            'ttl' => $this->ttl,
            'weight' => $this->weight,
        ];
    }
}
