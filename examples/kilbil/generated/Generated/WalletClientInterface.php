<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated;

use Acme\Kilbil\Generated\Model\GetWalletLinkRequest;
use Acme\Kilbil\Generated\Model\GetWalletLinkResponse;

/**
 * The contract for the `Wallet` endpoints.
 *
 * Type-hint this rather than the class: hand-written convenience implements the same
 * contract and delegates to the generated implementation, so a regeneration that changes
 * the surface fails to compile instead of silently breaking the seam.
 */
interface WalletClientInterface
{
    public function getWalletLink(GetWalletLinkRequest $body): GetWalletLinkResponse;
}
