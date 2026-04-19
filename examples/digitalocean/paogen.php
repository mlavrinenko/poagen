<?php

declare(strict_types=1);

use Mlavrinenko\Paogen\Generator\Profile;

return new Profile(
    schema: __DIR__ . '/schemas/DigitalOcean-public.v2.yaml',
    output: __DIR__ . '/generated',
    namespace: 'Acme\\DigitalOcean',
);
