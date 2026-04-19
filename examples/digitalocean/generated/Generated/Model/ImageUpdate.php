<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\Distribution;
use JsonSerializable;

final readonly class ImageUpdate implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'description' => ['description', \Acme\DigitalOcean\Generated\Model\ImageDescription::class],
        'distribution' => ['distribution', ['enum', \Acme\DigitalOcean\Generated\Enum\Distribution::class]],
        'name' => ['name', \Acme\DigitalOcean\Generated\Model\ImageName::class],
    ];

    public function __construct(
        public ?ImageDescription $description = null,
        public ?Distribution $distribution = null,
        public ?ImageName $name = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'description' => $this->description,
            'distribution' => $this->distribution,
            'name' => $this->name,
        ];
    }
}
