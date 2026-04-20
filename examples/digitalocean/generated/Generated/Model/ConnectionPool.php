<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ConnectionPool
{
    /**
     * @param ?mixed $connection
     * @param ?mixed $private_connection
     * @param ?mixed $standby_connection
     * @param ?mixed $standby_private_connection
     */
    public function __construct(
        public string $db,
        public string $mode,
        public string $name,
        public int $size,
        public $connection = null,
        public $private_connection = null,
        public $standby_connection = null,
        public $standby_private_connection = null,
        public ?string $user = null,
    ) {
    }
}
