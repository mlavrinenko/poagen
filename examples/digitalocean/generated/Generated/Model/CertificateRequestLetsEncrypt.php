<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class CertificateRequestLetsEncrypt implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'dns_names' => ['dns_names', ['list', null]],
        'name' => ['name', null],
        'type' => ['type', null],
    ];

    /**
     * @param list<string> $dns_names
     */
    public function __construct(
        public array $dns_names,
        public string $name,
        public ?string $type = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'dns_names' => $this->dns_names,
            'name' => $this->name,
            'type' => $this->type,
        ];
    }
}
