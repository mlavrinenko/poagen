<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class BasicError implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'documentation_url' => ['documentation_url', null],
        'message' => ['message', null],
        'status' => ['status', null],
        'url' => ['url', null],
    ];

    public function __construct(
        public ?string $documentation_url = null,
        public ?string $message = null,
        public ?string $status = null,
        public ?string $url = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'documentation_url' => $this->documentation_url,
            'message' => $this->message,
            'status' => $this->status,
            'url' => $this->url,
        ];
    }
}
