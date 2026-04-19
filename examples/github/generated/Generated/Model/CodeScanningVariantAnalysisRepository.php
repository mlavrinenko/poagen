<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class CodeScanningVariantAnalysisRepository implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'full_name' => ['full_name', null],
        'id' => ['id', null],
        'name' => ['name', null],
        'private' => ['private', null],
        'stargazers_count' => ['stargazers_count', null],
        'updated_at' => ['updated_at', ['datetime', null]],
    ];

    public function __construct(
        public string $full_name,
        public int $id,
        public string $name,
        public bool $private,
        public int $stargazers_count,
        public ?DateTimeImmutable $updated_at = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'full_name' => $this->full_name,
            'id' => $this->id,
            'name' => $this->name,
            'private' => $this->private,
            'stargazers_count' => $this->stargazers_count,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
        ];
    }
}
