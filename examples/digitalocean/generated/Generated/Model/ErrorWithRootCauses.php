<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ErrorWithRootCauses implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'error' => ['error', null],
        'root_causes' => ['root_causes', ['list', null]],
        'messages' => ['messages', ['list', null]],
    ];

    /**
     * @param list<string> $root_causes
     * @param ?list<string> $messages
     */
    public function __construct(
        public string $error,
        public array $root_causes,
        public ?array $messages = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'error' => $this->error,
            'root_causes' => $this->root_causes,
            'messages' => $this->messages,
        ];
    }
}
