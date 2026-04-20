<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiListModelApikeysOutput
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiModelApikeyInfo> $api_key_infos
     */
    public function __construct(
        public ?array $api_key_infos = null,
        public ?ApiLinks $links = null,
        public ?ApiMeta $meta = null,
    ) {
    }
}
