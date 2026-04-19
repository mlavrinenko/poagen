<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class UpdateEndpoint implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'certificate_id' => ['certificate_id', null],
        'custom_domain' => ['custom_domain', null],
        'ttl' => ['ttl', null],
    ];

    public function __construct(
        public ?string $certificate_id = null,
        public ?string $custom_domain = null,
        public ?int $ttl = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'certificate_id' => $this->certificate_id,
            'custom_domain' => $this->custom_domain,
            'ttl' => $this->ttl,
        ];
    }
}
