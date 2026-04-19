<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\ApiDeploymentStatus;
use Acme\DigitalOcean\Generated\Enum\ApiDeploymentVisibility;
use DateTimeImmutable;
use JsonSerializable;

final readonly class ApiDeployment implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'name' => ['name', null],
        'status' => ['status', ['enum', \Acme\DigitalOcean\Generated\Enum\ApiDeploymentStatus::class]],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'uuid' => ['uuid', null],
        'visibility' => ['visibility', ['enum', \Acme\DigitalOcean\Generated\Enum\ApiDeploymentVisibility::class]],
    ];

    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?string $name = null,
        public ?ApiDeploymentStatus $status = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?string $url = null,
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
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'name' => $this->name,
            'status' => $this->status,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'uuid' => $this->uuid,
            'visibility' => $this->visibility,
        ];
    }
}
