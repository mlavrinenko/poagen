<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AlertPolicy implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'alerts' => ['alerts', \Acme\DigitalOcean\Generated\Model\Alerts::class],
        'compare' => ['compare', null],
        'description' => ['description', null],
        'enabled' => ['enabled', null],
        'entities' => ['entities', ['list', null]],
        'tags' => ['tags', ['list', null]],
        'type' => ['type', null],
        'uuid' => ['uuid', null],
        'value' => ['value', null],
        'window' => ['window', null],
    ];

    /**
     * @param list<string> $entities
     * @param list<string> $tags
     */
    public function __construct(
        public Alerts $alerts,
        public string $compare,
        public string $description,
        public bool $enabled,
        public array $entities,
        public array $tags,
        public string $type,
        public string $uuid,
        public float $value,
        public string $window,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'alerts' => $this->alerts,
            'compare' => $this->compare,
            'description' => $this->description,
            'enabled' => $this->enabled,
            'entities' => $this->entities,
            'tags' => $this->tags,
            'type' => $this->type,
            'uuid' => $this->uuid,
            'value' => $this->value,
            'window' => $this->window,
        ];
    }
}
