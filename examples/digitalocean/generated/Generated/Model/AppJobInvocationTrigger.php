<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppJobInvocationTrigger implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'manual' => ['manual', \Acme\DigitalOcean\Generated\Model\AppJobInvocationTriggerManual::class],
        'scheduled' => ['scheduled', \Acme\DigitalOcean\Generated\Model\AppJobInvocationTriggerScheduled::class],
        'type' => ['type', null],
    ];

    public function __construct(
        public ?AppJobInvocationTriggerManual $manual = null,
        public ?AppJobInvocationTriggerScheduled $scheduled = null,
        public ?string $type = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'manual' => $this->manual,
            'scheduled' => $this->scheduled,
            'type' => $this->type,
        ];
    }
}
