<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class SuppressedResourceRootMeta implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['page' => ['page', null], 'pages' => ['pages', null], 'total' => ['total', null]];

    public function __construct(
        public ?int $page = null,
        public ?int $pages = null,
        public ?int $total = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'page' => $this->page,
            'pages' => $this->pages,
            'total' => $this->total,
        ];
    }
}
