<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookPersonalAccessTokenRequestCancelled implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'action' => ['action', null],
        'installation' => ['installation', \Acme\GitHub\Generated\Model\SimpleInstallation::class],
        'organization' => ['organization', \Acme\GitHub\Generated\Model\OrganizationSimpleWebhooks::class],
        'personal_access_token_request' => [
            'personal_access_token_request',
            \Acme\GitHub\Generated\Model\PersonalAccessTokenRequest::class,
        ],
        'sender' => ['sender', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'enterprise' => ['enterprise', \Acme\GitHub\Generated\Model\EnterpriseWebhooks::class],
    ];

    public function __construct(
        public string $action,
        public SimpleInstallation $installation,
        public OrganizationSimpleWebhooks $organization,
        public PersonalAccessTokenRequest $personal_access_token_request,
        public SimpleUser $sender,
        public ?EnterpriseWebhooks $enterprise = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'action' => $this->action,
            'installation' => $this->installation,
            'organization' => $this->organization,
            'personal_access_token_request' => $this->personal_access_token_request,
            'sender' => $this->sender,
            'enterprise' => $this->enterprise,
        ];
    }
}
