<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Autolink implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'id' => ['id', null],
        'is_alphanumeric' => ['is_alphanumeric', null],
        'key_prefix' => ['key_prefix', null],
        'url_template' => ['url_template', null],
        'updated_at' => ['updated_at', ['datetime', null]],
    ];

    public function __construct(
        public int $id,
        public bool $is_alphanumeric,
        public string $key_prefix,
        public string $url_template,
        public ?DateTimeImmutable $updated_at = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'is_alphanumeric' => $this->is_alphanumeric,
            'key_prefix' => $this->key_prefix,
            'url_template' => $this->url_template,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
        ];
    }
}
