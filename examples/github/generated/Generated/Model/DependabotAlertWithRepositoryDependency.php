<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class DependabotAlertWithRepositoryDependency implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'manifest_path' => ['manifest_path', null],
        'package' => ['package', \Acme\GitHub\Generated\Model\DependabotAlertPackage::class],
        'relationship' => ['relationship', null],
        'scope' => ['scope', null],
    ];

    public function __construct(
        public ?string $manifest_path = null,
        public ?DependabotAlertPackage $package = null,
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
            'manifest_path' => $this->manifest_path,
            'package' => $this->package,
            'relationship' => $this->relationship,
            'scope' => $this->scope,
        ];
    }
}
