<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated;

use Acme\Kilbil\Generated\Model\GeneratePromocodeRequest;
use Acme\Kilbil\Generated\Model\GeneratePromocodeResponse;
use Acme\Kilbil\Generated\Model\ReservedPromocodeRequest;
use Acme\Kilbil\Generated\Model\ReservedPromocodeResponse;
use Acme\Kilbil\Generated\Model\SearchPromocodeRequest;
use Acme\Kilbil\Generated\Model\SearchPromocodeResponse;

/**
 * The contract for the `Промокоды` endpoints.
 *
 * Type-hint this rather than the class: hand-written convenience implements the same
 * contract and delegates to the generated implementation, so a regeneration that changes
 * the surface fails to compile instead of silently breaking the seam.
 */
interface PromocodesClientInterface
{
    public function generatePromocode(GeneratePromocodeRequest $body): GeneratePromocodeResponse;

    public function reservedPromocode(ReservedPromocodeRequest $body): ReservedPromocodeResponse;

    public function searchPromocode(SearchPromocodeRequest $body): SearchPromocodeResponse;
}
