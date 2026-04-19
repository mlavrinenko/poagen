<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookProjectsV2ProjectReopened implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'action' => ['action', null],
        'organization' => ['organization', \Acme\GitHub\Generated\Model\OrganizationSimpleWebhooks::class],
        'projects_v2' => ['projects_v2', \Acme\GitHub\Generated\Model\ProjectsV2::class],
        'sender' => ['sender', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'installation' => ['installation', \Acme\GitHub\Generated\Model\SimpleInstallation::class],
    ];

    public function __construct(
        public string $action,
        public OrganizationSimpleWebhooks $organization,
        public ProjectsV2 $projects_v2,
        public SimpleUser $sender,
        public ?SimpleInstallation $installation = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'action' => $this->action,
            'organization' => $this->organization,
            'projects_v2' => $this->projects_v2,
            'sender' => $this->sender,
            'installation' => $this->installation,
        ];
    }
}
