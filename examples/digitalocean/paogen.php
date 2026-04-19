<?php

declare(strict_types=1);

use Mlavrinenko\Paogen\Generator\Profile;

return new Profile(
    schema: __DIR__ . '/schemas/DigitalOcean-public.v2.yaml',
    output: __DIR__ . '/generated',
    namespace: 'Acme\\DigitalOcean',
    // Two schema components (`version-2`, `urn-2`) carry names that
    // aren't valid PHP class identifiers. The `renames` field is
    // documented (ADR-003) as the escape hatch for this, but today
    // the map is only consulted at one emission site — cross-refs
    // from other components still try to resolve against the raw
    // names and abort the run. Tracked as T-023.
    renames: [
        'version-2' => 'Version2',
        'urn-2' => 'Urn2',
    ],
);
