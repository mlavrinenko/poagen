<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CodeOfConductSimple implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'html_url' => ['html_url', null],
        'key' => ['key', null],
        'name' => ['name', null],
        'url' => ['url', null],
    ];

    public function __construct(
        public ?string $html_url = null,
        public string $key,
        public string $name,
        public string $url,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'html_url' => $this->html_url,
            'key' => $this->key,
            'name' => $this->name,
            'url' => $this->url,
        ];
    }
}
