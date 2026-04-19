<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ProjectAssignment implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'resources' => ['resources', ['list', \Acme\DigitalOcean\Generated\Model\Urn::class]],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\Urn> $resources
     */
    public function __construct(
        public ?array $resources = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'resources' => $this->resources,
        ];
    }
}
