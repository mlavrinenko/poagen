<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookProjectEditedChanges implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'body' => ['body', \Acme\GitHub\Generated\Model\WebhookProjectEditedChangesBody::class],
        'name' => ['name', \Acme\GitHub\Generated\Model\WebhookProjectEditedChangesName::class],
    ];

    public function __construct(
        public ?WebhookProjectEditedChangesBody $body = null,
        public ?WebhookProjectEditedChangesName $name = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'body' => $this->body,
            'name' => $this->name,
        ];
    }
}
