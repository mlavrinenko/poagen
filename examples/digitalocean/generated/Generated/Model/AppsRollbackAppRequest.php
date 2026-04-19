<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppsRollbackAppRequest implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['deployment_id' => ['deployment_id', null], 'skip_pin' => ['skip_pin', null]];

    public function __construct(
        public ?string $deployment_id = null,
        public ?bool $skip_pin = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'deployment_id' => $this->deployment_id,
            'skip_pin' => $this->skip_pin,
        ];
    }
}
