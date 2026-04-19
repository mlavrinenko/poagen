<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class WebhookCheckSuiteRerequestedCheck_suiteApp implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'description' => ['description', null],
        'external_url' => ['external_url', null],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'name' => ['name', null],
        'node_id' => ['node_id', null],
        'owner' => ['owner', \Acme\GitHub\Generated\Model\WebhookCheckSuiteRerequestedCheck_suiteAppOwner::class],
        'updated_at' => ['updated_at', ['datetime', null]],
        'client_id' => ['client_id', null],
        'events' => ['events', ['list', null]],
        'permissions' => [
            'permissions',
            \Acme\GitHub\Generated\Model\WebhookCheckSuiteRerequestedCheck_suiteAppPermissions::class,
        ],
        'slug' => ['slug', null],
    ];

    /**
     * @param ?list<string> $events
     */
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?string $description = null,
        public ?string $external_url = null,
        public string $html_url,
        public ?int $id = null,
        public string $name,
        public string $node_id,
        public WebhookCheckSuiteRerequestedCheck_suiteAppOwner $owner,
        public ?DateTimeImmutable $updated_at = null,
        public ?string $client_id = null,
        public ?array $events = null,
        public ?WebhookCheckSuiteRerequestedCheck_suiteAppPermissions $permissions = null,
        public ?string $slug = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'description' => $this->description,
            'external_url' => $this->external_url,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'name' => $this->name,
            'node_id' => $this->node_id,
            'owner' => $this->owner,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
            'client_id' => $this->client_id,
            'events' => $this->events,
            'permissions' => $this->permissions,
            'slug' => $this->slug,
        ];
    }
}
