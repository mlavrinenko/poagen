<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class DependencyGraphSpdxSbomSbomCreationInfo
{
    /**
     * @param list<string> $creators
     */
    public function __construct(
        public string $created,
        public array $creators,
    ) {
    }
}
