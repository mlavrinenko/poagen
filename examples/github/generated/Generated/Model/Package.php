<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Package implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'name' => ['name', null],
        'package_type' => ['package_type', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'version_count' => ['version_count', null],
        'visibility' => ['visibility', null],
        'owner' => ['owner', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\NullableMinimalRepository::class],
    ];

    public function __construct(
        public DateTimeImmutable $created_at,
        public string $html_url,
        public int $id,
        public string $name,
        public string $package_type,
        public DateTimeImmutable $updated_at,
        public string $url,
        public int $version_count,
        public string $visibility,
        public ?NullableSimpleUser $owner = null,
        public ?NullableMinimalRepository $repository = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'html_url' => $this->html_url,
            'id' => $this->id,
            'name' => $this->name,
            'package_type' => $this->package_type,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'version_count' => $this->version_count,
            'visibility' => $this->visibility,
            'owner' => $this->owner,
            'repository' => $this->repository,
        ];
    }
}
