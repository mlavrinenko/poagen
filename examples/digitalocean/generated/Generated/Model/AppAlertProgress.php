<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppAlertProgress implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'steps' => ['steps', ['list', \Acme\DigitalOcean\Generated\Model\AppAlertProgressStep::class]],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppAlertProgressStep> $steps
     */
    public function __construct(
        public ?array $steps = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'steps' => $this->steps,
        ];
    }
}
