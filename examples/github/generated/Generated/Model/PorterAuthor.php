<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class PorterAuthor implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'email' => ['email', null],
        'id' => ['id', null],
        'import_url' => ['import_url', null],
        'name' => ['name', null],
        'remote_id' => ['remote_id', null],
        'remote_name' => ['remote_name', null],
        'url' => ['url', null],
    ];

    public function __construct(
        public string $email,
        public int $id,
        public string $import_url,
        public string $name,
        public string $remote_id,
        public string $remote_name,
        public string $url,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'email' => $this->email,
            'id' => $this->id,
            'import_url' => $this->import_url,
            'name' => $this->name,
            'remote_id' => $this->remote_id,
            'remote_name' => $this->remote_name,
            'url' => $this->url,
        ];
    }
}
