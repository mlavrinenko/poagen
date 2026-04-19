<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookLabelEditedChanges implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'color' => ['color', \Acme\GitHub\Generated\Model\WebhookLabelEditedChangesColor::class],
        'description' => ['description', \Acme\GitHub\Generated\Model\WebhookLabelEditedChangesDescription::class],
        'name' => ['name', \Acme\GitHub\Generated\Model\WebhookLabelEditedChangesName::class],
    ];

    public function __construct(
        public ?WebhookLabelEditedChangesColor $color = null,
        public ?WebhookLabelEditedChangesDescription $description = null,
        public ?WebhookLabelEditedChangesName $name = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'color' => $this->color,
            'description' => $this->description,
            'name' => $this->name,
        ];
    }
}
