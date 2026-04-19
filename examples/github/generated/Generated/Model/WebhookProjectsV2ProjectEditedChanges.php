<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookProjectsV2ProjectEditedChanges implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'description' => [
            'description',
            \Acme\GitHub\Generated\Model\WebhookProjectsV2ProjectEditedChangesDescription::class,
        ],
        'public' => ['public', \Acme\GitHub\Generated\Model\WebhookProjectsV2ProjectEditedChangesPublic::class],
        'short_description' => [
            'short_description',
            \Acme\GitHub\Generated\Model\WebhookProjectsV2ProjectEditedChangesShort_description::class,
        ],
        'title' => ['title', \Acme\GitHub\Generated\Model\WebhookProjectsV2ProjectEditedChangesTitle::class],
    ];

    public function __construct(
        public ?WebhookProjectsV2ProjectEditedChangesDescription $description = null,
        public ?WebhookProjectsV2ProjectEditedChangesPublic $public = null,
        public ?WebhookProjectsV2ProjectEditedChangesShort_description $short_description = null,
        public ?WebhookProjectsV2ProjectEditedChangesTitle $title = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'description' => $this->description,
            'public' => $this->public,
            'short_description' => $this->short_description,
            'title' => $this->title,
        ];
    }
}
