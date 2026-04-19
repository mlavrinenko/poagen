<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookProjectsV2ItemReorderedChanges implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'previous_projects_v2_item_node_id' => [
            'previous_projects_v2_item_node_id',
            \Acme\GitHub\Generated\Model\WebhookProjectsV2ItemReorderedChangesPrevious_projects_v2_item_node_id::class,
        ],
    ];

    public function __construct(
        public ?WebhookProjectsV2ItemReorderedChangesPrevious_projects_v2_item_node_id $previous_projects_v2_item_node_id = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'previous_projects_v2_item_node_id' => $this->previous_projects_v2_item_node_id,
        ];
    }
}
