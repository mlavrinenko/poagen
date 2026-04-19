<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CodeScanningDefaultSetupOptions implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['runner_label' => ['runner_label', null], 'runner_type' => ['runner_type', null]];

    public function __construct(
        public ?string $runner_label = null,
        public ?string $runner_type = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'runner_label' => $this->runner_label,
            'runner_type' => $this->runner_type,
        ];
    }
}
