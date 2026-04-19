<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AutoscalePoolDropletTemplate implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'image' => ['image', null],
        'region' => ['region', null],
        'size' => ['size', null],
        'ssh_keys' => ['ssh_keys', ['list', null]],
        'ipv6' => ['ipv6', null],
        'name' => ['name', null],
        'project_id' => ['project_id', null],
        'public_networking' => ['public_networking', null],
        'tags' => ['tags', ['list', null]],
        'user_data' => ['user_data', null],
        'vpc_uuid' => ['vpc_uuid', null],
        'with_droplet_agent' => ['with_droplet_agent', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'image' => $this->image,
            'region' => $this->region,
            'size' => $this->size,
            'ssh_keys' => $this->ssh_keys,
            'ipv6' => $this->ipv6,
            'name' => $this->name,
            'project_id' => $this->project_id,
            'public_networking' => $this->public_networking,
            'tags' => $this->tags,
            'user_data' => $this->user_data,
            'vpc_uuid' => $this->vpc_uuid,
            'with_droplet_agent' => $this->with_droplet_agent,
        ];
    }
}
