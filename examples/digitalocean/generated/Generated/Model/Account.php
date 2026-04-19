<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class Account implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'droplet_limit' => ['droplet_limit', null],
        'email' => ['email', null],
        'email_verified' => ['email_verified', null],
        'floating_ip_limit' => ['floating_ip_limit', null],
        'status' => ['status', null],
        'status_message' => ['status_message', null],
        'uuid' => ['uuid', null],
        'name' => ['name', null],
        'team' => ['team', \Acme\DigitalOcean\Generated\Model\AccountTeam::class],
    ];

    public function __construct(
        public int $droplet_limit,
        public string $email,
        public bool $email_verified,
        public int $floating_ip_limit,
        public string $status,
        public string $status_message,
        public string $uuid,
        public ?string $name = null,
        public ?AccountTeam $team = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'droplet_limit' => $this->droplet_limit,
            'email' => $this->email,
            'email_verified' => $this->email_verified,
            'floating_ip_limit' => $this->floating_ip_limit,
            'status' => $this->status,
            'status_message' => $this->status_message,
            'uuid' => $this->uuid,
            'name' => $this->name,
            'team' => $this->team,
        ];
    }
}
