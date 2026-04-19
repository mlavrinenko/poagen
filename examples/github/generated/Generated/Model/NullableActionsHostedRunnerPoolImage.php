<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class NullableActionsHostedRunnerPoolImage implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'display_name' => ['display_name', null],
        'id' => ['id', null],
        'size_gb' => ['size_gb', null],
        'source' => ['source', null],
        'version' => ['version', null],
    ];

    public function __construct(
        public string $display_name,
        public string $id,
        public int $size_gb,
        public string $source,
        public ?string $version = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'display_name' => $this->display_name,
            'id' => $this->id,
            'size_gb' => $this->size_gb,
            'source' => $this->source,
            'version' => $this->version,
        ];
    }
}
