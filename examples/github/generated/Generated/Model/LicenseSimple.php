<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class LicenseSimple implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'key' => ['key', null],
        'name' => ['name', null],
        'node_id' => ['node_id', null],
        'spdx_id' => ['spdx_id', null],
        'url' => ['url', null],
        'html_url' => ['html_url', null],
    ];

    public function __construct(
        public string $key,
        public string $name,
        public string $node_id,
        public ?string $spdx_id = null,
        public ?string $url = null,
        public ?string $html_url = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'key' => $this->key,
            'name' => $this->name,
            'node_id' => $this->node_id,
            'spdx_id' => $this->spdx_id,
            'url' => $this->url,
            'html_url' => $this->html_url,
        ];
    }
}
