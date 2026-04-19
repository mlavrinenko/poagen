<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class DependencyGraphSpdxSbom implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['sbom' => ['sbom', \Acme\GitHub\Generated\Model\DependencyGraphSpdxSbomSbom::class]];

    public function __construct(
        public DependencyGraphSpdxSbomSbom $sbom,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'sbom' => $this->sbom,
        ];
    }
}
