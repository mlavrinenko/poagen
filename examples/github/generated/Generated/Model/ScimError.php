<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ScimError implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'detail' => ['detail', null],
        'documentation_url' => ['documentation_url', null],
        'message' => ['message', null],
        'schemas' => ['schemas', ['list', null]],
        'scimType' => ['scimType', null],
        'status' => ['status', null],
    ];

    /**
     * @param ?list<string> $schemas
     */
    public function __construct(
        public ?string $detail = null,
        public ?string $documentation_url = null,
        public ?string $message = null,
        public ?array $schemas = null,
        public ?string $scimType = null,
        public ?int $status = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'detail' => $this->detail,
            'documentation_url' => $this->documentation_url,
            'message' => $this->message,
            'schemas' => $this->schemas,
            'scimType' => $this->scimType,
            'status' => $this->status,
        ];
    }
}
