<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class TriggerInfo implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', null],
        'function' => ['function', null],
        'is_enabled' => ['is_enabled', null],
        'name' => ['name', null],
        'namespace' => ['namespace', null],
        'scheduled_details' => ['scheduled_details', \Acme\DigitalOcean\Generated\Model\ScheduledDetails::class],
        'scheduled_runs' => ['scheduled_runs', \Acme\DigitalOcean\Generated\Model\TriggerInfoScheduled_runs::class],
        'type' => ['type', null],
        'updated_at' => ['updated_at', null],
    ];

    public function __construct(
        public ?string $created_at = null,
        public ?string $function = null,
        public ?bool $is_enabled = null,
        public ?string $name = null,
        public ?string $namespace = null,
        public ?ScheduledDetails $scheduled_details = null,
        public ?TriggerInfoScheduled_runs $scheduled_runs = null,
        public ?string $type = null,
        public ?string $updated_at = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at,
            'function' => $this->function,
            'is_enabled' => $this->is_enabled,
            'name' => $this->name,
            'namespace' => $this->namespace,
            'scheduled_details' => $this->scheduled_details,
            'scheduled_runs' => $this->scheduled_runs,
            'type' => $this->type,
            'updated_at' => $this->updated_at,
        ];
    }
}
