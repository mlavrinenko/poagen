<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class DependencyGraphSpdxSbomSbom implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'SPDXID' => ['SPDXID', null],
        'creationInfo' => ['creationInfo', \Acme\GitHub\Generated\Model\DependencyGraphSpdxSbomSbomCreationInfo::class],
        'dataLicense' => ['dataLicense', null],
        'documentNamespace' => ['documentNamespace', null],
        'name' => ['name', null],
        'packages' => ['packages', ['list', null]],
        'spdxVersion' => ['spdxVersion', null],
        'comment' => ['comment', null],
        'relationships' => ['relationships', ['list', null]],
    ];

    /**
     * @param list<array<string, mixed>> $packages
     * @param ?list<array<string, mixed>> $relationships
     */
    public function __construct(
        public string $SPDXID,
        public DependencyGraphSpdxSbomSbomCreationInfo $creationInfo,
        public string $dataLicense,
        public string $documentNamespace,
        public string $name,
        public array $packages,
        public string $spdxVersion,
        public ?string $comment = null,
        public ?array $relationships = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'SPDXID' => $this->SPDXID,
            'creationInfo' => $this->creationInfo,
            'dataLicense' => $this->dataLicense,
            'documentNamespace' => $this->documentNamespace,
            'name' => $this->name,
            'packages' => $this->packages,
            'spdxVersion' => $this->spdxVersion,
            'comment' => $this->comment,
            'relationships' => $this->relationships,
        ];
    }
}
