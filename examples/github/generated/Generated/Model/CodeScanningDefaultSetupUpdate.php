<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CodeScanningDefaultSetupUpdate implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'languages' => ['languages', ['list', null]],
        'query_suite' => ['query_suite', null],
        'runner_label' => ['runner_label', null],
        'runner_type' => ['runner_type', null],
        'state' => ['state', null],
        'threat_model' => ['threat_model', null],
    ];

    /**
     * @param ?list<string> $languages
     */
    public function __construct(
        public ?array $languages = null,
        public ?string $query_suite = null,
        public ?string $runner_label = null,
        public ?string $runner_type = null,
        public ?string $state = null,
        public ?string $threat_model = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'languages' => $this->languages,
            'query_suite' => $this->query_suite,
            'runner_label' => $this->runner_label,
            'runner_type' => $this->runner_type,
            'state' => $this->state,
            'threat_model' => $this->threat_model,
        ];
    }
}
