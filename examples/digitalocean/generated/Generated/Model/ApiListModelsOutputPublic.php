<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiListModelsOutputPublic implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'links' => ['links', \Acme\DigitalOcean\Generated\Model\ApiLinks::class],
        'meta' => ['meta', \Acme\DigitalOcean\Generated\Model\ApiMeta::class],
        'models' => ['models', ['list', \Acme\DigitalOcean\Generated\Model\ApiModelPublic::class]],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiModelPublic> $models
     */
    public function __construct(
        public ?ApiLinks $links = null,
        public ?ApiMeta $meta = null,
        public ?array $models = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'links' => $this->links,
            'meta' => $this->meta,
            'models' => $this->models,
        ];
    }
}
