<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DropletSingleCreate
{
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
}
