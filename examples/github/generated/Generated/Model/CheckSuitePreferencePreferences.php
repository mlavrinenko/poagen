<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CheckSuitePreferencePreferences implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['auto_trigger_checks' => ['auto_trigger_checks', ['list', null]]];

    /**
     * @param ?list<array<string, mixed>> $auto_trigger_checks
     */
    public function __construct(
        public ?array $auto_trigger_checks = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'auto_trigger_checks' => $this->auto_trigger_checks,
        ];
    }
}
