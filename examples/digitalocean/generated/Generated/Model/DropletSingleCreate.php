<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class DropletSingleCreate implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'image' => ['image', null],
        'name' => ['name', null],
        'size' => ['size', null],
        'backup_policy' => ['backup_policy', null],
        'backups' => ['backups', null],
        'ipv6' => ['ipv6', null],
        'monitoring' => ['monitoring', null],
        'private_networking' => ['private_networking', null],
        'public_networking' => ['public_networking', null],
        'region' => ['region', null],
        'ssh_keys' => ['ssh_keys', ['list', null]],
        'tags' => ['tags', ['list', null]],
        'user_data' => ['user_data', null],
        'volumes' => ['volumes', ['list', null]],
        'vpc_uuid' => ['vpc_uuid', null],
        'with_droplet_agent' => ['with_droplet_agent', null],
    ];

    /**
     * @param mixed $image
     * @param ?mixed $backup_policy
     * @param ?list<mixed> $ssh_keys
     * @param ?list<string> $tags
     * @param ?list<string> $volumes
     */
    public function __construct(
        public $image,
        public string $name,
        public string $size,
        public $backup_policy = null,
        public ?bool $backups = null,
        public ?bool $ipv6 = null,
        public ?bool $monitoring = null,
        public ?bool $private_networking = null,
        public ?bool $public_networking = null,
        public ?string $region = null,
        public ?array $ssh_keys = null,
        public ?array $tags = null,
        public ?string $user_data = null,
        public ?array $volumes = null,
        public ?string $vpc_uuid = null,
        public ?bool $with_droplet_agent = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'image' => $this->image,
            'name' => $this->name,
            'size' => $this->size,
            'backup_policy' => $this->backup_policy,
            'backups' => $this->backups,
            'ipv6' => $this->ipv6,
            'monitoring' => $this->monitoring,
            'private_networking' => $this->private_networking,
            'public_networking' => $this->public_networking,
            'region' => $this->region,
            'ssh_keys' => $this->ssh_keys,
            'tags' => $this->tags,
            'user_data' => $this->user_data,
            'volumes' => $this->volumes,
            'vpc_uuid' => $this->vpc_uuid,
            'with_droplet_agent' => $this->with_droplet_agent,
        ];
    }
}
