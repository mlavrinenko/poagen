<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppJobInvocationTriggerManualUser implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'email' => ['email', null],
        'full_name' => ['full_name', null],
        'uuid' => ['uuid', null],
    ];

    public function __construct(
        public ?string $email = null,
        public ?string $full_name = null,
        public ?string $uuid = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'email' => $this->email,
            'full_name' => $this->full_name,
            'uuid' => $this->uuid,
        ];
    }
}
