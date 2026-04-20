<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class DependencyGraphSpdxSbomSbom
{
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
}
