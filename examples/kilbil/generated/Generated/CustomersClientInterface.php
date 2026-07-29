<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated;

use Acme\Kilbil\Generated\Model\AddClientRequest;
use Acme\Kilbil\Generated\Model\AddClientResponse;
use Acme\Kilbil\Generated\Model\BlockCardRequest;
use Acme\Kilbil\Generated\Model\BlockCardResponse;
use Acme\Kilbil\Generated\Model\GetClientCardsRequest;
use Acme\Kilbil\Generated\Model\GetClientCardsResponse;
use Acme\Kilbil\Generated\Model\GetClientFullBalanceRequest;
use Acme\Kilbil\Generated\Model\GetClientFullBalanceResponseItem;
use Acme\Kilbil\Generated\Model\GetConfirmationCodeRequest;
use Acme\Kilbil\Generated\Model\GetConfirmationCodeResponse;
use Acme\Kilbil\Generated\Model\ReplaceCardRequest;
use Acme\Kilbil\Generated\Model\ReplaceCardResponse;
use Acme\Kilbil\Generated\Model\SearchClientRequest;
use Acme\Kilbil\Generated\Model\SearchClientResponse;

/**
 * The contract for the `Клиенты` endpoints.
 *
 * Type-hint this rather than the class: hand-written convenience implements the same
 * contract and delegates to the generated implementation, so a regeneration that changes
 * the surface fails to compile instead of silently breaking the seam.
 */
interface CustomersClientInterface
{
    public function addClient(AddClientRequest $body): AddClientResponse;

    public function blockCard(BlockCardRequest $body): BlockCardResponse;

    public function getClientCards(GetClientCardsRequest $body): GetClientCardsResponse;

    /**
     * @return list<\Acme\Kilbil\Generated\Model\GetClientFullBalanceResponseItem>
     */
    public function getClientFullBalance(GetClientFullBalanceRequest $body): array;

    public function getConfirmationCode(GetConfirmationCodeRequest $body): GetConfirmationCodeResponse;

    public function replaceCard(ReplaceCardRequest $body): ReplaceCardResponse;

    public function searchClient(SearchClientRequest $body): SearchClientResponse;
}
