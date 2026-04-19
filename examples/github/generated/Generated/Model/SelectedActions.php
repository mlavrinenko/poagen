<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class SelectedActions implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'github_owned_allowed' => ['github_owned_allowed', null],
        'patterns_allowed' => ['patterns_allowed', ['list', null]],
        'verified_allowed' => ['verified_allowed', null],
    ];

    /**
     * @param ?list<string> $patterns_allowed
     */
    public function __construct(
        public ?bool $github_owned_allowed = null,
        public ?array $patterns_allowed = null,
        public ?bool $verified_allowed = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'github_owned_allowed' => $this->github_owned_allowed,
            'patterns_allowed' => $this->patterns_allowed,
            'verified_allowed' => $this->verified_allowed,
        ];
    }
}
