<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CopilotDotcomChat implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'models' => ['models', ['list', null]],
        'total_engaged_users' => ['total_engaged_users', null],
    ];

    /**
     * @param ?list<array<string, mixed>> $models
     */
    public function __construct(
        public ?array $models = null,
        public ?int $total_engaged_users = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'models' => $this->models,
            'total_engaged_users' => $this->total_engaged_users,
        ];
    }
}
