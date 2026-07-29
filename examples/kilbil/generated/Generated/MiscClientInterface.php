<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated;

use Acme\Kilbil\Generated\Model\CloseSessionRequest;
use Acme\Kilbil\Generated\Model\CloseSessionResponse;
use Acme\Kilbil\Generated\Model\ExchangePosSettingsRequest;
use Acme\Kilbil\Generated\Model\ExchangePosSettingsResponse;
use Acme\Kilbil\Generated\Model\GenerateCardRequest;
use Acme\Kilbil\Generated\Model\GenerateCardResponse;
use Acme\Kilbil\Generated\Model\LegalInfoResponse;

/**
 * The contract for the `Другое` endpoints.
 *
 * Type-hint this rather than the class: hand-written convenience implements the same
 * contract and delegates to the generated implementation, so a regeneration that changes
 * the surface fails to compile instead of silently breaking the seam.
 */
interface MiscClientInterface
{
    public function closeSession(CloseSessionRequest $body): CloseSessionResponse;

    public function exchangePosSettings(ExchangePosSettingsRequest $body): ExchangePosSettingsResponse;

    public function generateCard(GenerateCardRequest $body): GenerateCardResponse;

    public function legalInfo(): LegalInfoResponse;
}
