<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppInstances implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'instances' => ['instances', ['list', \Acme\DigitalOcean\Generated\Model\AppInstance::class]],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppInstance> $instances
     */
    public function __construct(
        public ?array $instances = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'instances' => $this->instances,
        ];
    }
}
