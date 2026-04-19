<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AddonsAppInfo implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'app_slug' => ['app_slug', null],
        'eula' => ['eula', null],
        'plans' => ['plans', ['list', \Acme\DigitalOcean\Generated\Model\AddonsPlan::class]],
        'tos' => ['tos', null],
    ];

    /**
     * @param list<\Acme\DigitalOcean\Generated\Model\AddonsPlan> $plans
     */
    public function __construct(
        public string $app_slug,
        public string $eula,
        public array $plans,
        public string $tos,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'app_slug' => $this->app_slug,
            'eula' => $this->eula,
            'plans' => $this->plans,
            'tos' => $this->tos,
        ];
    }
}
