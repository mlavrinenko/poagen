<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class UserSettingsMongo_user_settings
{
    /**
     * @param ?list<string> $databases
     */
    public function __construct(
        public ?array $databases = null,
        public ?string $role = null,
    ) {
    }
}
