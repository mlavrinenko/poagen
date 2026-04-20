<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DockerCredentials
{
    public function __construct(
        public ?DockerCredentialsAuths $auths = null,
    ) {
    }
}
