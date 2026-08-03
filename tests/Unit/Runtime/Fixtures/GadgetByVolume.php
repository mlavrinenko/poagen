<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Unit\Runtime\Fixtures;

use Mlavrinenko\Paogen\Tests\Integration\XmlRequestBodyTest;

/**
 * Mirrors `gadget_by_volume` in `union-request-body-3.0.yaml` — the other
 * branch of the same `oneOf` request body union — the way {@see Contact}
 * mirrors kilbil's `contact` schema for {@see XmlRequestBodyTest}.
 */
final readonly class GadgetByVolume
{
    public function __construct(public float $volume) {}
}
