<?php

declare(strict_types=1);

use Mlavrinenko\Paogen\Generator\Profile;

return new Profile(
    schema: __DIR__ . '/schemas/api.github.com.yaml',
    output: __DIR__ . '/generated',
    namespace: 'Acme\\GitHub',
    // The GitHub REST schema declares ~918 components, 818 of which
    // use kebab-case names (`security-advisory-ecosystems`, etc.).
    // Enumerating every one here by hand is not a realistic user
    // experience, so this profile leaves `renames` empty and waits
    // for T-023's pluggable name-normalisation strategies.
);
