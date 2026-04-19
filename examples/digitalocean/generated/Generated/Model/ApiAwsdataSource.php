<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiAwsdataSource implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'bucket_name' => ['bucket_name', null],
        'item_path' => ['item_path', null],
        'key_id' => ['key_id', null],
        'region' => ['region', null],
        'secret_key' => ['secret_key', null],
    ];

    public function __construct(
        public ?string $bucket_name = null,
        public ?string $item_path = null,
        public ?string $key_id = null,
        public ?string $region = null,
        public ?string $secret_key = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'bucket_name' => $this->bucket_name,
            'item_path' => $this->item_path,
            'key_id' => $this->key_id,
            'region' => $this->region,
            'secret_key' => $this->secret_key,
        ];
    }
}
