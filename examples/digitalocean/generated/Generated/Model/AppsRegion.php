<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppsRegion implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'continent' => ['continent', null],
        'data_centers' => ['data_centers', ['list', null]],
        'default' => ['default', null],
        'disabled' => ['disabled', null],
        'flag' => ['flag', null],
        'label' => ['label', null],
        'reason' => ['reason', null],
        'slug' => ['slug', null],
    ];

    /**
     * @param ?list<string> $data_centers
     */
    public function __construct(
        public ?string $continent = null,
        public ?array $data_centers = null,
        public ?bool $default = null,
        public ?bool $disabled = null,
        public ?string $flag = null,
        public ?string $label = null,
        public ?string $reason = null,
        public ?string $slug = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'continent' => $this->continent,
            'data_centers' => $this->data_centers,
            'default' => $this->default,
            'disabled' => $this->disabled,
            'flag' => $this->flag,
            'label' => $this->label,
            'reason' => $this->reason,
            'slug' => $this->slug,
        ];
    }
}
