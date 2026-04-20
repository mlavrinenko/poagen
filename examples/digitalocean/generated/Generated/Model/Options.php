<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class Options
{
    public function __construct(
        public ?OptionsOptions $options = null,
        public ?OptionsVersion_availability $version_availability = null,
    ) {
    }
}
