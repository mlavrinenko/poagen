<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class ActionsHostedRunner implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'id' => ['id', null],
        'image_details' => ['image_details', \Acme\GitHub\Generated\Model\NullableActionsHostedRunnerPoolImage::class],
        'machine_size_details' => [
            'machine_size_details',
            \Acme\GitHub\Generated\Model\ActionsHostedRunnerMachineSpec::class,
        ],
        'name' => ['name', null],
        'platform' => ['platform', null],
        'public_ip_enabled' => ['public_ip_enabled', null],
        'status' => ['status', null],
        'image_gen' => ['image_gen', null],
        'last_active_on' => ['last_active_on', ['datetime', null]],
        'maximum_runners' => ['maximum_runners', null],
        'public_ips' => ['public_ips', ['list', \Acme\GitHub\Generated\Model\PublicIp::class]],
        'runner_group_id' => ['runner_group_id', null],
    ];

    /**
     * @param ?list<\Acme\GitHub\Generated\Model\PublicIp> $public_ips
     */
    public function __construct(
        public int $id,
        public NullableActionsHostedRunnerPoolImage $image_details,
        public ActionsHostedRunnerMachineSpec $machine_size_details,
        public string $name,
        public string $platform,
        public bool $public_ip_enabled,
        public string $status,
        public ?bool $image_gen = null,
        public ?DateTimeImmutable $last_active_on = null,
        public ?int $maximum_runners = null,
        public ?array $public_ips = null,
        public ?int $runner_group_id = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'image_details' => $this->image_details,
            'machine_size_details' => $this->machine_size_details,
            'name' => $this->name,
            'platform' => $this->platform,
            'public_ip_enabled' => $this->public_ip_enabled,
            'status' => $this->status,
            'image_gen' => $this->image_gen,
            'last_active_on' => $this->last_active_on?->format(\DateTimeInterface::RFC3339),
            'maximum_runners' => $this->maximum_runners,
            'public_ips' => $this->public_ips,
            'runner_group_id' => $this->runner_group_id,
        ];
    }
}
