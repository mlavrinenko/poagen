<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookPush implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'after' => ['after', null],
        'base_ref' => ['base_ref', \Acme\GitHub\Generated\Model\WebhooksNullableString::class],
        'before' => ['before', null],
        'commits' => ['commits', ['list', null]],
        'compare' => ['compare', null],
        'created' => ['created', null],
        'deleted' => ['deleted', null],
        'forced' => ['forced', null],
        'head_commit' => ['head_commit', \Acme\GitHub\Generated\Model\WebhookPushHead_commit::class],
        'pusher' => ['pusher', \Acme\GitHub\Generated\Model\WebhookPushPusher::class],
        'ref' => ['ref', null],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\WebhookPushRepository::class],
        'enterprise' => ['enterprise', \Acme\GitHub\Generated\Model\EnterpriseWebhooks::class],
        'installation' => ['installation', \Acme\GitHub\Generated\Model\SimpleInstallation::class],
        'organization' => ['organization', \Acme\GitHub\Generated\Model\OrganizationSimpleWebhooks::class],
        'sender' => ['sender', \Acme\GitHub\Generated\Model\SimpleUser::class],
    ];

    /**
     * @param list<array<string, mixed>> $commits
     */
    public function __construct(
        public string $after,
        public WebhooksNullableString $base_ref,
        public string $before,
        public array $commits,
        public string $compare,
        public bool $created,
        public bool $deleted,
        public bool $forced,
        public WebhookPushHead_commit $head_commit,
        public WebhookPushPusher $pusher,
        public string $ref,
        public WebhookPushRepository $repository,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?SimpleUser $sender = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'after' => $this->after,
            'base_ref' => $this->base_ref,
            'before' => $this->before,
            'commits' => $this->commits,
            'compare' => $this->compare,
            'created' => $this->created,
            'deleted' => $this->deleted,
            'forced' => $this->forced,
            'head_commit' => $this->head_commit,
            'pusher' => $this->pusher,
            'ref' => $this->ref,
            'repository' => $this->repository,
            'enterprise' => $this->enterprise,
            'installation' => $this->installation,
            'organization' => $this->organization,
            'sender' => $this->sender,
        ];
    }
}
