<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiListModelsOutputPublic
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiModelPublic> $models
     */
    public function __construct(
        public ?ApiLinks $links = null,
        public ?ApiMeta $meta = null,
        public ?array $models = null,
    ) {
    }
}
