<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class User
{
    public function __construct(
        public ?UserKubernetes_cluster_user $kubernetes_cluster_user = null,
    ) {
    }
}
