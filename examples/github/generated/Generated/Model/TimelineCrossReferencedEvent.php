<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class TimelineCrossReferencedEvent implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'event' => ['event', null],
        'source' => ['source', \Acme\GitHub\Generated\Model\TimelineCrossReferencedEventSource::class],
        'updated_at' => ['updated_at', ['datetime', null]],
        'actor' => ['actor', \Acme\GitHub\Generated\Model\SimpleUser::class],
    ];

    public function __construct(
        public DateTimeImmutable $created_at,
        public string $event,
        public TimelineCrossReferencedEventSource $source,
        public DateTimeImmutable $updated_at,
        public ?SimpleUser $actor = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'event' => $this->event,
            'source' => $this->source,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'actor' => $this->actor,
        ];
    }
}
