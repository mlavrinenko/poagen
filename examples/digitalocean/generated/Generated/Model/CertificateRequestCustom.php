<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class CertificateRequestCustom implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'leaf_certificate' => ['leaf_certificate', null],
        'name' => ['name', null],
        'private_key' => ['private_key', null],
        'certificate_chain' => ['certificate_chain', null],
        'type' => ['type', null],
    ];

    public function __construct(
        public string $leaf_certificate,
        public string $name,
        public string $private_key,
        public ?string $certificate_chain = null,
        public ?string $type = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'leaf_certificate' => $this->leaf_certificate,
            'name' => $this->name,
            'private_key' => $this->private_key,
            'certificate_chain' => $this->certificate_chain,
            'type' => $this->type,
        ];
    }
}
