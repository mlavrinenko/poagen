<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiAuditHeader implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'actor_id' => ['actor_id', null],
        'actor_ip' => ['actor_ip', null],
        'actor_uuid' => ['actor_uuid', null],
        'context_urn' => ['context_urn', null],
        'origin_application' => ['origin_application', null],
        'user_id' => ['user_id', null],
        'user_uuid' => ['user_uuid', null],
    ];

    public function __construct(
        public ?string $actor_id = null,
        public ?string $actor_ip = null,
        public ?string $actor_uuid = null,
        public ?string $context_urn = null,
        public ?string $origin_application = null,
        public ?string $user_id = null,
        public ?string $user_uuid = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'actor_id' => $this->actor_id,
            'actor_ip' => $this->actor_ip,
            'actor_uuid' => $this->actor_uuid,
            'context_urn' => $this->context_urn,
            'origin_application' => $this->origin_application,
            'user_id' => $this->user_id,
            'user_uuid' => $this->user_uuid,
        ];
    }
}
