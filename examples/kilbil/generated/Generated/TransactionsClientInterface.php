<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated;

use Acme\Kilbil\Generated\Model\ConfirmSaleRequest;
use Acme\Kilbil\Generated\Model\ConfirmSaleResponse;
use Acme\Kilbil\Generated\Model\GetDetailingByMoveRequest;
use Acme\Kilbil\Generated\Model\GetDetailingByMoveResponse;
use Acme\Kilbil\Generated\Model\GetMovesByClientRequest;
use Acme\Kilbil\Generated\Model\GetMovesByClientResponse;
use Acme\Kilbil\Generated\Model\ManualAddRequest;
use Acme\Kilbil\Generated\Model\ManualAddResponse;
use Acme\Kilbil\Generated\Model\ProcessSaleRequest;
use Acme\Kilbil\Generated\Model\ProcessSaleResponse;

/**
 * The contract for the `Операции` endpoints.
 *
 * Type-hint this rather than the class: hand-written convenience implements the same
 * contract and delegates to the generated implementation, so a regeneration that changes
 * the surface fails to compile instead of silently breaking the seam.
 */
interface TransactionsClientInterface
{
    public function confirmSale(ConfirmSaleRequest $body): ConfirmSaleResponse;

    public function getDetailingByMove(GetDetailingByMoveRequest $body): GetDetailingByMoveResponse;

    public function getMovesByClient(GetMovesByClientRequest $body): GetMovesByClientResponse;

    public function manualAdd(ManualAddRequest $body): ManualAddResponse;

    public function processSale(ProcessSaleRequest $body): ProcessSaleResponse;
}
