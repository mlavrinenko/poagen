<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppHealth implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'components' => ['components', ['list', \Acme\DigitalOcean\Generated\Model\AppComponentHealth::class]],
        'functions_components' => [
            'functions_components',
            ['list', \Acme\DigitalOcean\Generated\Model\AppFunctionsComponentHealth::class],
        ],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppComponentHealth> $components
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppFunctionsComponentHealth> $functions_components
     */
    public function __construct(
        public ?array $components = null,
        public ?array $functions_components = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'components' => $this->components,
            'functions_components' => $this->functions_components,
        ];
    }
}
