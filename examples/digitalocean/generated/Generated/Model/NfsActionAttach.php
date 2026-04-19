<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class NfsActionAttach implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'type' => ['type', null],
        'params' => ['params', \Acme\DigitalOcean\Generated\Model\NfsActionAttachParams::class],
        'region' => ['region', null],
    ];

    public function __construct(
        public string $type,
        public ?NfsActionAttachParams $params = null,
        public ?string $region = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'type' => $this->type,
            'params' => $this->params,
            'region' => $this->region,
        ];
    }
}
