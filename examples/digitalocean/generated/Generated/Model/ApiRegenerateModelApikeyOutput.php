<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiRegenerateModelApikeyOutput implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'api_key_info' => ['api_key_info', \Acme\DigitalOcean\Generated\Model\ApiModelApikeyInfo::class],
    ];

    public function __construct(
        public ?ApiModelApikeyInfo $api_key_info = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'api_key_info' => $this->api_key_info,
        ];
    }
}
