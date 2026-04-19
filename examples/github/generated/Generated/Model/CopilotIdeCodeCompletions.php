<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CopilotIdeCodeCompletions implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'editors' => ['editors', ['list', null]],
        'languages' => ['languages', ['list', null]],
        'total_engaged_users' => ['total_engaged_users', null],
    ];

    /**
     * @param ?list<array<string, mixed>> $editors
     * @param ?list<array<string, mixed>> $languages
     */
    public function __construct(
        public ?array $editors = null,
        public ?array $languages = null,
        public ?int $total_engaged_users = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'editors' => $this->editors,
            'languages' => $this->languages,
            'total_engaged_users' => $this->total_engaged_users,
        ];
    }
}
