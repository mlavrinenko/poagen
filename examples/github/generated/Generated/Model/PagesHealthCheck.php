<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class PagesHealthCheck implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'alt_domain' => ['alt_domain', \Acme\GitHub\Generated\Model\PagesHealthCheckAlt_domain::class],
        'domain' => ['domain', \Acme\GitHub\Generated\Model\PagesHealthCheckDomain::class],
    ];

    public function __construct(
        public ?PagesHealthCheckAlt_domain $alt_domain = null,
        public ?PagesHealthCheckDomain $domain = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'alt_domain' => $this->alt_domain,
            'domain' => $this->domain,
        ];
    }
}
