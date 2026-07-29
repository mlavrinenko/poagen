<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated;

use Acme\Kilbil\Generated\Model\GetSalesIndicesSlidesRequest;
use Acme\Kilbil\Generated\Model\GetSalesIndicesSlidesResponse;

/**
 * The contract for the `План-факт` endpoints.
 *
 * Type-hint this rather than the class: hand-written convenience implements the same
 * contract and delegates to the generated implementation, so a regeneration that changes
 * the surface fails to compile instead of silently breaking the seam.
 */
interface SalesPlanClientInterface
{
    public function getSalesIndicesSlides(GetSalesIndicesSlidesRequest $body): GetSalesIndicesSlidesResponse;
}
