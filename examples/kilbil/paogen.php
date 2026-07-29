<?php

declare(strict_types=1);

use Mlavrinenko\Paogen\Generator\Profile;

return new Profile(
    schema: __DIR__ . '/schemas/loyalty_v1.yaml',
    output: __DIR__ . '/generated',
    namespace: 'Acme\\Kilbil',
);
