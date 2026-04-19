<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CodeScanningSarifsStatus implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'analyses_url' => ['analyses_url', null],
        'errors' => ['errors', ['list', null]],
        'processing_status' => ['processing_status', null],
    ];

    /**
     * @param ?list<string> $errors
     */
    public function __construct(
        public ?string $analyses_url = null,
        public ?array $errors = null,
        public ?string $processing_status = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'analyses_url' => $this->analyses_url,
            'errors' => $this->errors,
            'processing_status' => $this->processing_status,
        ];
    }
}
