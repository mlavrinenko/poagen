<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookPing implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'hook' => ['hook', \Acme\GitHub\Generated\Model\WebhookPingHook::class],
        'hook_id' => ['hook_id', null],
        'organization' => ['organization', \Acme\GitHub\Generated\Model\OrganizationSimpleWebhooks::class],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\RepositoryWebhooks::class],
        'sender' => ['sender', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'zen' => ['zen', null],
    ];

    public function __construct(
        public ?WebhookPingHook $hook = null,
        public ?int $hook_id = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?RepositoryWebhooks $repository = null,
        public ?SimpleUser $sender = null,
        public ?string $zen = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'hook' => $this->hook,
            'hook_id' => $this->hook_id,
            'organization' => $this->organization,
            'repository' => $this->repository,
            'sender' => $this->sender,
            'zen' => $this->zen,
        ];
    }
}
