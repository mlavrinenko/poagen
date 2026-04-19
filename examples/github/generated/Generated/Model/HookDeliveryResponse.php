<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class HookDeliveryResponse implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['headers' => ['headers', null], 'payload' => ['payload', null]];

    /**
     * @param ?array<string, mixed> $headers
     */
    public function __construct(
        public ?array $headers = null,
        public ?string $payload = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'headers' => $this->headers,
            'payload' => $this->payload,
        ];
    }
}
