<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookProjectsV2ItemConvertedChanges implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'content_type' => [
            'content_type',
            \Acme\GitHub\Generated\Model\WebhookProjectsV2ItemConvertedChangesContent_type::class,
        ],
    ];

    public function __construct(
        public ?WebhookProjectsV2ItemConvertedChangesContent_type $content_type = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'content_type' => $this->content_type,
        ];
    }
}
