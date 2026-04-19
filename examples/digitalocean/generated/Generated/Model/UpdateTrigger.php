<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class UpdateTrigger implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'is_enabled' => ['is_enabled', null],
        'scheduled_details' => ['scheduled_details', \Acme\DigitalOcean\Generated\Model\ScheduledDetails::class],
    ];

    public function __construct(
        public ?bool $is_enabled = null,
        public ?ScheduledDetails $scheduled_details = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'is_enabled' => $this->is_enabled,
            'scheduled_details' => $this->scheduled_details,
        ];
    }
}
