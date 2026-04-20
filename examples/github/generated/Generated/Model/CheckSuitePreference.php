<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CheckSuitePreference
{
    public function __construct(
        public CheckSuitePreferencePreferences $preferences,
        public MinimalRepository $repository,
    ) {
    }
}
