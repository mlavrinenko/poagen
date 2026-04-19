<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiListOpenAiapikeysOutput implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'api_key_infos' => ['api_key_infos', ['list', \Acme\DigitalOcean\Generated\Model\ApiOpenAiapikeyInfo::class]],
        'links' => ['links', \Acme\DigitalOcean\Generated\Model\ApiLinks::class],
        'meta' => ['meta', \Acme\DigitalOcean\Generated\Model\ApiMeta::class],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiOpenAiapikeyInfo> $api_key_infos
     */
    public function __construct(
        public ?array $api_key_infos = null,
        public ?ApiLinks $links = null,
        public ?ApiMeta $meta = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'api_key_infos' => $this->api_key_infos,
            'links' => $this->links,
            'meta' => $this->meta,
        ];
    }
}
