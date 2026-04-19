<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiSpacesDataSource implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'bucket_name' => ['bucket_name', null],
        'item_path' => ['item_path', null],
        'region' => ['region', null],
    ];

    public function __construct(
        public ?string $bucket_name = null,
        public ?string $item_path = null,
        public ?string $region = null,
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
            'region' => $this->region,
        ];
    }
}
