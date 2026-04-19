<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CvssSeverities implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'cvss_v3' => ['cvss_v3', \Acme\GitHub\Generated\Model\CvssSeveritiesCvss_v3::class],
        'cvss_v4' => ['cvss_v4', \Acme\GitHub\Generated\Model\CvssSeveritiesCvss_v4::class],
    ];

    public function __construct(
        public ?CvssSeveritiesCvss_v3 $cvss_v3 = null,
        public ?CvssSeveritiesCvss_v4 $cvss_v4 = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'cvss_v3' => $this->cvss_v3,
            'cvss_v4' => $this->cvss_v4,
        ];
    }
}
