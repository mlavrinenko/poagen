<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppVariableDefinition implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'key' => ['key', null],
        'scope' => ['scope', null],
        'type' => ['type', null],
        'value' => ['value', null],
    ];

    public function __construct(
        public string $key,
        public ?string $scope = null,
        public ?string $type = null,
        public ?string $value = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'key' => $this->key,
            'scope' => $this->scope,
            'type' => $this->type,
            'value' => $this->value,
        ];
    }
}
