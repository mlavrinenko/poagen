<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ProtectedBranchRequiredStatusCheck implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'checks' => ['checks', ['list', null]],
        'contexts' => ['contexts', ['list', null]],
        'contexts_url' => ['contexts_url', null],
        'enforcement_level' => ['enforcement_level', null],
        'strict' => ['strict', null],
        'url' => ['url', null],
    ];

    /**
     * @param list<array<string, mixed>> $checks
     * @param list<string> $contexts
     */
    public function __construct(
        public array $checks,
        public array $contexts,
        public ?string $contexts_url = null,
        public ?string $enforcement_level = null,
        public ?bool $strict = null,
        public ?string $url = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'checks' => $this->checks,
            'contexts' => $this->contexts,
            'contexts_url' => $this->contexts_url,
            'enforcement_level' => $this->enforcement_level,
            'strict' => $this->strict,
            'url' => $this->url,
        ];
    }
}
