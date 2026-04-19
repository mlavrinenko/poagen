<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class DatabaseVersionAvailability implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'end_of_availability' => ['end_of_availability', null],
        'end_of_life' => ['end_of_life', null],
        'version' => ['version', null],
    ];

    public function __construct(
        public ?string $end_of_availability = null,
        public ?string $end_of_life = null,
        public ?string $version = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'end_of_availability' => $this->end_of_availability,
            'end_of_life' => $this->end_of_life,
            'version' => $this->version,
        ];
    }
}
