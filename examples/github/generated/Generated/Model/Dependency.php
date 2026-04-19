<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class Dependency implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'dependencies' => ['dependencies', ['list', null]],
        'metadata' => ['metadata', \Acme\GitHub\Generated\Model\Metadata::class],
        'package_url' => ['package_url', null],
        'relationship' => ['relationship', null],
        'scope' => ['scope', null],
    ];

    /**
     * @param ?list<string> $dependencies
     */
    public function __construct(
        public ?array $dependencies = null,
        public ?Metadata $metadata = null,
        public ?string $package_url = null,
        public ?string $relationship = null,
        public ?string $scope = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'dependencies' => $this->dependencies,
            'metadata' => $this->metadata,
            'package_url' => $this->package_url,
            'relationship' => $this->relationship,
            'scope' => $this->scope,
        ];
    }
}
