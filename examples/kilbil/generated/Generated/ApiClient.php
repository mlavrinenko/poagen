<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated;

use Mlavrinenko\Paogen\Runtime\Marshal\Hydrator;
use Mlavrinenko\Paogen\Runtime\Marshal\Marshaller;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

final readonly class ApiClient implements ApiClientInterface
{
    public function __construct(
        private ClientInterface $httpClient,
        private RequestFactoryInterface $requestFactory,
        private StreamFactoryInterface $streamFactory,
        private string $baseUri,
        private Hydrator $hydrator = new Hydrator(),
        private Marshaller $marshaller = new Marshaller(),
    ) {
    }

    /**
     * The `Номенклатура` endpoints.
     */
    public function catalogue(): CatalogueClientInterface
    {
        return new CatalogueClient($this->httpClient, $this->requestFactory, $this->streamFactory, $this->baseUri, $this->hydrator, $this->marshaller);
    }

    /**
     * The `Код подтверждения` endpoints.
     */
    public function confirmationCodes(): ConfirmationCodesClientInterface
    {
        return new ConfirmationCodesClient($this->httpClient, $this->requestFactory, $this->streamFactory, $this->baseUri, $this->hydrator, $this->marshaller);
    }

    /**
     * The `Клиенты` endpoints.
     */
    public function customers(): CustomersClientInterface
    {
        return new CustomersClient($this->httpClient, $this->requestFactory, $this->streamFactory, $this->baseUri, $this->hydrator, $this->marshaller);
    }

    /**
     * The `Подарочные сертификаты` endpoints.
     */
    public function giftCertificates(): GiftCertificatesClientInterface
    {
        return new GiftCertificatesClient($this->httpClient, $this->requestFactory, $this->streamFactory, $this->baseUri, $this->hydrator, $this->marshaller);
    }

    /**
     * The `Информация о лояльности` endpoints.
     */
    public function loyaltySettings(): LoyaltySettingsClientInterface
    {
        return new LoyaltySettingsClient($this->httpClient, $this->requestFactory, $this->streamFactory, $this->baseUri, $this->hydrator, $this->marshaller);
    }

    /**
     * The `Другое` endpoints.
     */
    public function misc(): MiscClientInterface
    {
        return new MiscClient($this->httpClient, $this->requestFactory, $this->streamFactory, $this->baseUri, $this->hydrator, $this->marshaller);
    }

    /**
     * The `Промокоды` endpoints.
     */
    public function promocodes(): PromocodesClientInterface
    {
        return new PromocodesClient($this->httpClient, $this->requestFactory, $this->streamFactory, $this->baseUri, $this->hydrator, $this->marshaller);
    }

    /**
     * The `План-факт` endpoints.
     */
    public function salesPlan(): SalesPlanClientInterface
    {
        return new SalesPlanClient($this->httpClient, $this->requestFactory, $this->streamFactory, $this->baseUri, $this->hydrator, $this->marshaller);
    }

    /**
     * The `Теги` endpoints.
     */
    public function tags(): TagsClientInterface
    {
        return new TagsClient($this->httpClient, $this->requestFactory, $this->streamFactory, $this->baseUri, $this->hydrator, $this->marshaller);
    }

    /**
     * The `Операции` endpoints.
     */
    public function transactions(): TransactionsClientInterface
    {
        return new TransactionsClient($this->httpClient, $this->requestFactory, $this->streamFactory, $this->baseUri, $this->hydrator, $this->marshaller);
    }

    /**
     * The `Wallet` endpoints.
     */
    public function wallet(): WalletClientInterface
    {
        return new WalletClient($this->httpClient, $this->requestFactory, $this->streamFactory, $this->baseUri, $this->hydrator, $this->marshaller);
    }
}
