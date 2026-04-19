<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class RepositoryRuleViolationErrorMetadataSecret_scanning implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['bypass_placeholders' => ['bypass_placeholders', ['list', null]]];

    /**
     * @param ?list<array<string, mixed>> $bypass_placeholders
     */
    public function __construct(
        public ?array $bypass_placeholders = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'bypass_placeholders' => $this->bypass_placeholders,
        ];
    }
}
