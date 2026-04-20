<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class SshKeys
{
    public function __construct(
        public SshKeyName $name,
        public string $public_key,
        public ?SshKeyFingerprint $fingerprint = null,
        public ?SshKeyId $id = null,
    ) {
    }
}
