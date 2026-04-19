<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class IssueFieldValueSingle_select_option implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['color' => ['color', null], 'id' => ['id', null], 'name' => ['name', null]];

    public function __construct(
        public string $color,
        public int $id,
        public string $name,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'color' => $this->color,
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
