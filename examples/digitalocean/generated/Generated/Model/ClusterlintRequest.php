<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ClusterlintRequest implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'exclude_checks' => ['exclude_checks', ['list', null]],
        'exclude_groups' => ['exclude_groups', ['list', null]],
        'include_checks' => ['include_checks', ['list', null]],
        'include_groups' => ['include_groups', ['list', null]],
    ];

    /**
     * @param ?list<string> $exclude_checks
     * @param ?list<string> $exclude_groups
     * @param ?list<string> $include_checks
     * @param ?list<string> $include_groups
     */
    public function __construct(
        public ?array $exclude_checks = null,
        public ?array $exclude_groups = null,
        public ?array $include_checks = null,
        public ?array $include_groups = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'exclude_checks' => $this->exclude_checks,
            'exclude_groups' => $this->exclude_groups,
            'include_checks' => $this->include_checks,
            'include_groups' => $this->include_groups,
        ];
    }
}
