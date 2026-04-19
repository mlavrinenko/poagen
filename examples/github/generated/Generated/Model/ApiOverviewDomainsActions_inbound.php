<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ApiOverviewDomainsActions_inbound implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'full_domains' => ['full_domains', ['list', null]],
        'wildcard_domains' => ['wildcard_domains', ['list', null]],
    ];

    /**
     * @param ?list<string> $full_domains
     * @param ?list<string> $wildcard_domains
     */
    public function __construct(
        public ?array $full_domains = null,
        public ?array $wildcard_domains = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'full_domains' => $this->full_domains,
            'wildcard_domains' => $this->wildcard_domains,
        ];
    }
}
