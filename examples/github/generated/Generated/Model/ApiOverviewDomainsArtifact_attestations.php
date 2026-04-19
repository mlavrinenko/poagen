<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ApiOverviewDomainsArtifact_attestations implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['services' => ['services', ['list', null]], 'trust_domain' => ['trust_domain', null]];

    /**
     * @param ?list<string> $services
     */
    public function __construct(
        public ?array $services = null,
        public ?string $trust_domain = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'services' => $this->services,
            'trust_domain' => $this->trust_domain,
        ];
    }
}
