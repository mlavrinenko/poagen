<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ListModelsResponse implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'data' => ['data', ['list', \Acme\DigitalOcean\Generated\Model\Model::class]],
        'object' => ['object', null],
    ];

    /**
     * @param list<\Acme\DigitalOcean\Generated\Model\Model> $data
     */
    public function __construct(
        public array $data,
        public string $object,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'data' => $this->data,
            'object' => $this->object,
        ];
    }
}
