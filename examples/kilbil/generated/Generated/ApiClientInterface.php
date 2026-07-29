<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated;

/**
 * The composition root's contract: one accessor per tag, plus whatever the document left untagged.
 *
 * A service should depend on the sub-client interface it actually needs rather than on this — that grain is the point of the split.
 */
interface ApiClientInterface
{
    /**
     * The `Номенклатура` endpoints.
     */
    public function catalogue(): CatalogueClientInterface;

    /**
     * The `Код подтверждения` endpoints.
     */
    public function confirmationCodes(): ConfirmationCodesClientInterface;

    /**
     * The `Клиенты` endpoints.
     */
    public function customers(): CustomersClientInterface;

    /**
     * The `Подарочные сертификаты` endpoints.
     */
    public function giftCertificates(): GiftCertificatesClientInterface;

    /**
     * The `Информация о лояльности` endpoints.
     */
    public function loyaltySettings(): LoyaltySettingsClientInterface;

    /**
     * The `Другое` endpoints.
     */
    public function misc(): MiscClientInterface;

    /**
     * The `Промокоды` endpoints.
     */
    public function promocodes(): PromocodesClientInterface;

    /**
     * The `План-факт` endpoints.
     */
    public function salesPlan(): SalesPlanClientInterface;

    /**
     * The `Теги` endpoints.
     */
    public function tags(): TagsClientInterface;

    /**
     * The `Операции` endpoints.
     */
    public function transactions(): TransactionsClientInterface;

    /**
     * The `Wallet` endpoints.
     */
    public function wallet(): WalletClientInterface;
}
