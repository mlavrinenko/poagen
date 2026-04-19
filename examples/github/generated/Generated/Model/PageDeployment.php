<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class PageDeployment implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'id' => ['id', null],
        'page_url' => ['page_url', null],
        'status_url' => ['status_url', null],
        'preview_url' => ['preview_url', null],
    ];

    /**
     * @param mixed $id
     */
    public function __construct(
        public $id,
        public string $page_url,
        public string $status_url,
        public ?string $preview_url = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'page_url' => $this->page_url,
            'status_url' => $this->status_url,
            'preview_url' => $this->preview_url,
        ];
    }
}
