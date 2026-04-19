<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class DomainRecordCname implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'data' => ['data', null],
        'name' => ['name', null],
        'type' => ['type', null],
        'flags' => ['flags', null],
        'id' => ['id', null],
        'port' => ['port', null],
        'priority' => ['priority', null],
        'tag' => ['tag', null],
        'ttl' => ['ttl', null],
        'weight' => ['weight', null],
    ];

    public function __construct(
        public string $data,
        public string $name,
        public string $type,
        public ?int $flags = null,
        public ?int $id = null,
        public ?int $port = null,
        public ?int $priority = null,
        public ?string $tag = null,
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
            'name' => $this->name,
            'type' => $this->type,
            'flags' => $this->flags,
            'id' => $this->id,
            'port' => $this->port,
            'priority' => $this->priority,
            'tag' => $this->tag,
            'ttl' => $this->ttl,
            'weight' => $this->weight,
        ];
    }
}
