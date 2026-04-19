<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppsStringMatch implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['exact' => ['exact', null], 'prefix' => ['prefix', null], 'regex' => ['regex', null]];

    public function __construct(
        public ?string $exact = null,
        public ?string $prefix = null,
        public ?string $regex = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'exact' => $this->exact,
            'prefix' => $this->prefix,
            'regex' => $this->regex,
        ];
    }
}
