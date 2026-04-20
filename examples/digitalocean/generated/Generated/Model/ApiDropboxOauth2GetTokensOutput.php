<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiDropboxOauth2GetTokensOutput
{
    public function __construct(
        public ?string $refresh_token = null,
        public ?string $token = null,
    ) {
    }
}
