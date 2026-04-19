<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookProjectCardMovedChanges implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'column_id' => ['column_id', \Acme\GitHub\Generated\Model\WebhookProjectCardMovedChangesColumn_id::class],
    ];

    public function __construct(
        public WebhookProjectCardMovedChangesColumn_id $column_id,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'column_id' => $this->column_id,
        ];
    }
}
