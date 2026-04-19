<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class DependencyGraphSpdxSbomSbomCreationInfo implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['created' => ['created', null], 'creators' => ['creators', ['list', null]]];

    /**
     * @param list<string> $creators
     */
    public function __construct(
        public string $created,
        public array $creators,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created' => $this->created,
            'creators' => $this->creators,
        ];
    }
}
