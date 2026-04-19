<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppRouteSpec implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['path' => ['path', null], 'preserve_path_prefix' => ['preserve_path_prefix', null]];

    public function __construct(
        public ?string $path = null,
        public ?bool $preserve_path_prefix = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'path' => $this->path,
            'preserve_path_prefix' => $this->preserve_path_prefix,
        ];
    }
}
