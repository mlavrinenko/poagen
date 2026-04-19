<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookRepositoryEditedChanges implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'default_branch' => [
            'default_branch',
            \Acme\GitHub\Generated\Model\WebhookRepositoryEditedChangesDefault_branch::class,
        ],
        'description' => ['description', \Acme\GitHub\Generated\Model\WebhookRepositoryEditedChangesDescription::class],
        'homepage' => ['homepage', \Acme\GitHub\Generated\Model\WebhookRepositoryEditedChangesHomepage::class],
        'topics' => ['topics', \Acme\GitHub\Generated\Model\WebhookRepositoryEditedChangesTopics::class],
    ];

    public function __construct(
        public ?WebhookRepositoryEditedChangesDefault_branch $default_branch = null,
        public ?WebhookRepositoryEditedChangesDescription $description = null,
        public ?WebhookRepositoryEditedChangesHomepage $homepage = null,
        public ?WebhookRepositoryEditedChangesTopics $topics = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'default_branch' => $this->default_branch,
            'description' => $this->description,
            'homepage' => $this->homepage,
            'topics' => $this->topics,
        ];
    }
}
