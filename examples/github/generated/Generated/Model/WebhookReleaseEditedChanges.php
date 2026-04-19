<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookReleaseEditedChanges implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'body' => ['body', \Acme\GitHub\Generated\Model\WebhookReleaseEditedChangesBody::class],
        'make_latest' => ['make_latest', \Acme\GitHub\Generated\Model\WebhookReleaseEditedChangesMake_latest::class],
        'name' => ['name', \Acme\GitHub\Generated\Model\WebhookReleaseEditedChangesName::class],
        'tag_name' => ['tag_name', \Acme\GitHub\Generated\Model\WebhookReleaseEditedChangesTag_name::class],
    ];

    public function __construct(
        public ?WebhookReleaseEditedChangesBody $body = null,
        public ?WebhookReleaseEditedChangesMake_latest $make_latest = null,
        public ?WebhookReleaseEditedChangesName $name = null,
        public ?WebhookReleaseEditedChangesTag_name $tag_name = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'body' => $this->body,
            'make_latest' => $this->make_latest,
            'name' => $this->name,
            'tag_name' => $this->tag_name,
        ];
    }
}
