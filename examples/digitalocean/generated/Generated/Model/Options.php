<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class Options implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'options' => ['options', \Acme\DigitalOcean\Generated\Model\OptionsOptions::class],
        'version_availability' => [
            'version_availability',
            \Acme\DigitalOcean\Generated\Model\OptionsVersion_availability::class,
        ],
    ];

    public function __construct(
        public ?OptionsOptions $options = null,
        public ?OptionsVersion_availability $version_availability = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'options' => $this->options,
            'version_availability' => $this->version_availability,
        ];
    }
}
