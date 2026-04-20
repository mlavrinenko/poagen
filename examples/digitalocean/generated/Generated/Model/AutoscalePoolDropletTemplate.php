<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AutoscalePoolDropletTemplate
{
    /**
     * @param list<string> $ssh_keys
     * @param ?list<string> $tags
     */
    public function __construct(
        public string $image,
        public string $region,
        public string $size,
        public array $ssh_keys,
        public ?bool $ipv6 = null,
        public ?string $name = null,
        public ?string $project_id = null,
        public ?bool $public_networking = null,
        public ?array $tags = null,
        public ?string $user_data = null,
        public ?string $vpc_uuid = null,
        public ?bool $with_droplet_agent = null,
    ) {
    }
}
