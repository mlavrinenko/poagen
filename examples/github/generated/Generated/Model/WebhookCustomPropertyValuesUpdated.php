<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookCustomPropertyValuesUpdated
{
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
}
