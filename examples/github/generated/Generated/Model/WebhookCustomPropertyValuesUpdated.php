<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookCustomPropertyValuesUpdated implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'action' => ['action', null],
        'new_property_values' => ['new_property_values', ['list', \Acme\GitHub\Generated\Model\CustomPropertyValue::class]],
        'old_property_values' => ['old_property_values', ['list', \Acme\GitHub\Generated\Model\CustomPropertyValue::class]],
        'organization' => ['organization', \Acme\GitHub\Generated\Model\OrganizationSimpleWebhooks::class],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\RepositoryWebhooks::class],
        'enterprise' => ['enterprise', \Acme\GitHub\Generated\Model\EnterpriseWebhooks::class],
        'installation' => ['installation', \Acme\GitHub\Generated\Model\SimpleInstallation::class],
        'sender' => ['sender', \Acme\GitHub\Generated\Model\SimpleUser::class],
    ];

    /**
     * @param list<\Acme\GitHub\Generated\Model\CustomPropertyValue> $new_property_values
     * @param list<\Acme\GitHub\Generated\Model\CustomPropertyValue> $old_property_values
     */
    public function __construct(
        public string $action,
        public array $new_property_values,
        public array $old_property_values,
        public OrganizationSimpleWebhooks $organization,
        public RepositoryWebhooks $repository,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?SimpleUser $sender = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'action' => $this->action,
            'new_property_values' => $this->new_property_values,
            'old_property_values' => $this->old_property_values,
            'organization' => $this->organization,
            'repository' => $this->repository,
            'enterprise' => $this->enterprise,
            'installation' => $this->installation,
            'sender' => $this->sender,
        ];
    }
}
