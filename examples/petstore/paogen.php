<?php

declare(strict_types=1);

use Mlavrinenko\Paogen\Generator\Profile;

return new Profile(
    schema: __DIR__ . '/schemas/petstore-3.0.yaml',
    output: __DIR__ . '/generated',
    namespace: 'Acme\\Petstore',
);
