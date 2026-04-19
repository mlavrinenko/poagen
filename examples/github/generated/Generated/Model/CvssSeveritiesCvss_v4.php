<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CvssSeveritiesCvss_v4 implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['score' => ['score', null], 'vector_string' => ['vector_string', null]];

    public function __construct(
        public ?float $score = null,
        public ?string $vector_string = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'score' => $this->score,
            'vector_string' => $this->vector_string,
        ];
    }
}
