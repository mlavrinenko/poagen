<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookProjectsV2StatusUpdateEditedChanges implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'body' => ['body', \Acme\GitHub\Generated\Model\WebhookProjectsV2StatusUpdateEditedChangesBody::class],
        'start_date' => [
            'start_date',
            \Acme\GitHub\Generated\Model\WebhookProjectsV2StatusUpdateEditedChangesStart_date::class,
        ],
        'status' => ['status', \Acme\GitHub\Generated\Model\WebhookProjectsV2StatusUpdateEditedChangesStatus::class],
        'target_date' => [
            'target_date',
            \Acme\GitHub\Generated\Model\WebhookProjectsV2StatusUpdateEditedChangesTarget_date::class,
        ],
    ];

    public function __construct(
        public ?WebhookProjectsV2StatusUpdateEditedChangesBody $body = null,
        public ?WebhookProjectsV2StatusUpdateEditedChangesStart_date $start_date = null,
        public ?WebhookProjectsV2StatusUpdateEditedChangesStatus $status = null,
        public ?WebhookProjectsV2StatusUpdateEditedChangesTarget_date $target_date = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'body' => $this->body,
            'start_date' => $this->start_date,
            'status' => $this->status,
            'target_date' => $this->target_date,
        ];
    }
}
