<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class SshKeys implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'name' => ['name', \Acme\DigitalOcean\Generated\Model\SshKeyName::class],
        'public_key' => ['public_key', null],
        'fingerprint' => ['fingerprint', \Acme\DigitalOcean\Generated\Model\SshKeyFingerprint::class],
        'id' => ['id', \Acme\DigitalOcean\Generated\Model\SshKeyId::class],
    ];

    public function __construct(
        public SshKeyName $name,
        public string $public_key,
        public ?SshKeyFingerprint $fingerprint = null,
        public ?SshKeyId $id = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'public_key' => $this->public_key,
            'fingerprint' => $this->fingerprint,
            'id' => $this->id,
        ];
    }
}
