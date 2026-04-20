<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CheckSuitePreferencePreferences
{
    /**
     * @param ?list<array<string, mixed>> $auto_trigger_checks
     */
    public function __construct(
        public ?array $auto_trigger_checks = null,
    ) {
    }
}
