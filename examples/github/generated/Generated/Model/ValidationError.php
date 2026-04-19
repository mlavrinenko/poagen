<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ValidationError implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'documentation_url' => ['documentation_url', null],
        'message' => ['message', null],
        'errors' => ['errors', ['list', null]],
    ];

    /**
     * @param ?list<array<string, mixed>> $errors
     */
    public function __construct(
        public string $documentation_url,
        public string $message,
        public ?array $errors = null,
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
            'errors' => $this->errors,
        ];
    }
}
