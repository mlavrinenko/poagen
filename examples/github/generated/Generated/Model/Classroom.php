<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class Classroom implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'archived' => ['archived', null],
        'id' => ['id', null],
        'name' => ['name', null],
        'organization' => ['organization', \Acme\GitHub\Generated\Model\SimpleClassroomOrganization::class],
        'url' => ['url', null],
    ];

    public function __construct(
        public bool $archived,
        public int $id,
        public string $name,
        public SimpleClassroomOrganization $organization,
        public string $url,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'archived' => $this->archived,
            'id' => $this->id,
            'name' => $this->name,
            'organization' => $this->organization,
            'url' => $this->url,
        ];
    }
}
