<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class CreateTrigger implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'function' => ['function', null],
        'is_enabled' => ['is_enabled', null],
        'name' => ['name', null],
        'scheduled_details' => ['scheduled_details', \Acme\DigitalOcean\Generated\Model\ScheduledDetails::class],
        'type' => ['type', null],
    ];

    public function __construct(
        public string $function,
        public bool $is_enabled,
        public string $name,
        public ScheduledDetails $scheduled_details,
        public string $type,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'function' => $this->function,
            'is_enabled' => $this->is_enabled,
            'name' => $this->name,
            'scheduled_details' => $this->scheduled_details,
            'type' => $this->type,
        ];
    }
}
