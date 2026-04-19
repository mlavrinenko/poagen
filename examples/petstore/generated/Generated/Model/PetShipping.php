<?php

declare(strict_types=1);

namespace Acme\Petstore\Generated\Model;

use JsonSerializable;

final readonly class PetShipping implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['address' => ['address', null], 'zip' => ['zip', null]];

    public function __construct(
        public string $address,
        public ?string $zip = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'address' => $this->address,
            'zip' => $this->zip,
        ];
    }
}
