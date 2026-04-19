<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class DestinationRequest implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'config' => ['config', \Acme\DigitalOcean\Generated\Model\OpensearchConfigRequest::class],
        'type' => ['type', null],
        'name' => ['name', null],
    ];

    public function __construct(
        public OpensearchConfigRequest $config,
        public string $type,
        public ?string $name = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'config' => $this->config,
            'type' => $this->type,
            'name' => $this->name,
        ];
    }
}
