<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiGoogleDriveDataSourceDisplay implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['folder_id' => ['folder_id', null], 'folder_name' => ['folder_name', null]];

    public function __construct(
        public ?string $folder_id = null,
        public ?string $folder_name = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'folder_id' => $this->folder_id,
            'folder_name' => $this->folder_name,
        ];
    }
}
