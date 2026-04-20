<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiListAgentApikeysOutput
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiAgentApikeyInfo> $api_key_infos
     */
    public function __construct(
        public ?array $api_key_infos = null,
        public ?ApiLinks $links = null,
        public ?ApiMeta $meta = null,
    ) {
    }
}
