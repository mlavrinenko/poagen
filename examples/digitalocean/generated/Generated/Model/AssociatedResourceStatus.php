<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class AssociatedResourceStatus implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'completed_at' => ['completed_at', ['datetime', null]],
        'droplet' => ['droplet', \Acme\DigitalOcean\Generated\Model\DestroyedAssociatedResource::class],
        'failures' => ['failures', null],
        'resources' => ['resources', \Acme\DigitalOcean\Generated\Model\AssociatedResourceStatusResources::class],
    ];

    public function __construct(
        public ?DateTimeImmutable $completed_at = null,
        public ?DestroyedAssociatedResource $droplet = null,
        public ?int $failures = null,
        public ?AssociatedResourceStatusResources $resources = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'completed_at' => $this->completed_at?->format(\DateTimeInterface::RFC3339),
            'droplet' => $this->droplet,
            'failures' => $this->failures,
            'resources' => $this->resources,
        ];
    }
}
