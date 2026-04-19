<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CodeScanningAnalysisDeletion implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'confirm_delete_url' => ['confirm_delete_url', null],
        'next_analysis_url' => ['next_analysis_url', null],
    ];

    public function __construct(
        public ?string $confirm_delete_url = null,
        public ?string $next_analysis_url = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'confirm_delete_url' => $this->confirm_delete_url,
            'next_analysis_url' => $this->next_analysis_url,
        ];
    }
}
