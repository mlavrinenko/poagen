<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiRollbackToAgentVersionOutput implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'audit_header' => ['audit_header', \Acme\DigitalOcean\Generated\Model\ApiAuditHeader::class],
        'version_hash' => ['version_hash', null],
    ];

    public function __construct(
        public ?ApiAuditHeader $audit_header = null,
        public ?string $version_hash = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'audit_header' => $this->audit_header,
            'version_hash' => $this->version_hash,
        ];
    }
}
