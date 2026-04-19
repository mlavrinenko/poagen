<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CodespaceWithFullRepositoryRuntime_constraints implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['allowed_port_privacy_settings' => ['allowed_port_privacy_settings', ['list', null]]];

    /**
     * @param ?list<string> $allowed_port_privacy_settings
     */
    public function __construct(
        public ?array $allowed_port_privacy_settings = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'allowed_port_privacy_settings' => $this->allowed_port_privacy_settings,
        ];
    }
}
