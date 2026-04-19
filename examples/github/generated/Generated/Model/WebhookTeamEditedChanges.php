<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookTeamEditedChanges implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'description' => ['description', \Acme\GitHub\Generated\Model\WebhookTeamEditedChangesDescription::class],
        'name' => ['name', \Acme\GitHub\Generated\Model\WebhookTeamEditedChangesName::class],
        'notification_setting' => [
            'notification_setting',
            \Acme\GitHub\Generated\Model\WebhookTeamEditedChangesNotification_setting::class,
        ],
        'privacy' => ['privacy', \Acme\GitHub\Generated\Model\WebhookTeamEditedChangesPrivacy::class],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\WebhookTeamEditedChangesRepository::class],
    ];

    public function __construct(
        public ?WebhookTeamEditedChangesDescription $description = null,
        public ?WebhookTeamEditedChangesName $name = null,
        public ?WebhookTeamEditedChangesNotification_setting $notification_setting = null,
        public ?WebhookTeamEditedChangesPrivacy $privacy = null,
        public ?WebhookTeamEditedChangesRepository $repository = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'description' => $this->description,
            'name' => $this->name,
            'notification_setting' => $this->notification_setting,
            'privacy' => $this->privacy,
            'repository' => $this->repository,
        ];
    }
}
