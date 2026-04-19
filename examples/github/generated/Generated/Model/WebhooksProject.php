<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class WebhooksProject implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'body' => ['body', null],
        'columns_url' => ['columns_url', null],
        'created_at' => ['created_at', ['datetime', null]],
        'creator' => ['creator', \Acme\GitHub\Generated\Model\WebhooksProjectCreator::class],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'name' => ['name', null],
        'node_id' => ['node_id', null],
        'number' => ['number', null],
        'owner_url' => ['owner_url', null],
        'state' => ['state', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
    ];

    public function __construct(
        public ?string $body = null,
        public string $columns_url,
        public DateTimeImmutable $created_at,
        public WebhooksProjectCreator $creator,
        public string $html_url,
        public int $id,
        public string $name,
        public string $node_id,
        public int $number,
        public string $owner_url,
        public string $state,
        public DateTimeImmutable $updated_at,
        public string $url,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'body' => $this->body,
            'columns_url' => $this->columns_url,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'creator' => $this->creator,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'name' => $this->name,
            'node_id' => $this->node_id,
            'number' => $this->number,
            'owner_url' => $this->owner_url,
            'state' => $this->state,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
        ];
    }
}
