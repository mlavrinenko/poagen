<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\ApiDeploymentVisibility;
use JsonSerializable;

final readonly class ApiUpdateAgentDeploymentVisibilityInputPublic implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'uuid' => ['uuid', null],
        'visibility' => ['visibility', ['enum', \Acme\DigitalOcean\Generated\Enum\ApiDeploymentVisibility::class]],
    ];

    public function __construct(
        public ?string $uuid = null,
        public ?ApiDeploymentVisibility $visibility = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'uuid' => $this->uuid,
            'visibility' => $this->visibility,
        ];
    }
}
