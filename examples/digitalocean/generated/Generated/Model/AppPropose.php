<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppPropose implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'spec' => ['spec', \Acme\DigitalOcean\Generated\Model\AppSpec::class],
        'app_id' => ['app_id', null],
    ];

    public function __construct(
        public AppSpec $spec,
        public ?string $app_id = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'spec' => $this->spec,
            'app_id' => $this->app_id,
        ];
    }
}
