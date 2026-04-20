<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiDropboxOauth2GetTokensInput
{
    public function __construct(
        public ?string $code = null,
        public ?string $redirect_url = null,
    ) {
    }
}
