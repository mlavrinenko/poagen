<?php

declare(strict_types=1);

use Mlavrinenko\Paogen\Generator\Profile;

/**
 * Guidance for the kilbil loyalty API.
 *
 * This file is the demonstration that consumer guidance shapes the output —
 * `user-code-guides-generation`. Delete everything below `namespace:` and
 * generation still succeeds; the client is only less pleasant to call.
 */
return new Profile(
    schema: __DIR__ . '/schemas/loyalty_v1.yaml',
    output: __DIR__ . '/generated',
    namespace: 'Acme\\Kilbil',

    /*
     * Where paogen looks for this project's own `#[BindsFormat]` value objects.
     * The vendor writes nine format values across 292 uses and paogen knows one
     * of them, so it reports the other eight and `src/ValueObject/` answers the
     * four that carry meaning: `date time` and `data time` (both `date-time`
     * misspelled), `data` (`date` misspelled), and the invented `phone`.
     *
     * `int` and `double` are left unbound. A binding is keyed on the format
     * string document-wide, and `double` here means price, quantity, percentage
     * and balance alike — a Money bound to it would type every non-money double
     * as money too. See the README for the full reasoning and what a consumer
     * can do instead.
     */
    discoverIn: [
        'Acme\\Kilbil\\ValueObject',
    ],

    /*
     * All eleven tags are Russian words, and a tag names a sub-client class.
     * Without an answer here paogen transliterates deterministically —
     * `Клиенты` becomes `KlientyClient` — which is legible and grep-able but
     * not what anyone means. These are the names this project wants.
     *
     * `Wallet` is absent because the vendor already wrote it in ASCII, so the
     * default reads correctly.
     */
    /*
     * `goodsxml` and `goodslistxml` declare `application/xml` request bodies
     * whose schemas are arrays of inline objects. OpenAPI names the elements for
     * the properties — a property becomes an element of the same name — but names
     * nothing for the document root or for the repeated element of a bare array,
     * and this document carries no `xml:` metadata at all. paogen refuses to
     * invent either, because a wrong root element is a 400 from the vendor.
     *
     * These names follow the vendor's own vocabulary: the endpoint loads
     * "номенклатура" (catalogue items), and their description says the XML mirrors
     * the JSON structure. Confirm them against the vendor's XML samples before
     * sending a live request — paogen cannot, and the example makes no live call.
     */
    xmlElements: [
        'goodsxml' => 'goods',
        'goodsxml.item' => 'good',
        'goodslistxml' => 'goodslist',
        'goodslistxml.item' => 'good',
    ],

    tagRenames: [
        'Другое' => 'Misc',
        'Информация о лояльности' => 'LoyaltySettings',
        'Клиенты' => 'Customers',
        'Код подтверждения' => 'ConfirmationCodes',
        'Номенклатура' => 'Catalogue',
        'Операции' => 'Transactions',
        'План-факт' => 'SalesPlan',
        'Подарочные сертификаты' => 'GiftCertificates',
        'Промокоды' => 'Promocodes',
        'Теги' => 'Tags',
    ],

    /*
     * Every operation id in this document is lowercase and run together.
     * `getclientfullbalance` has no algorithmic path to `getClientFullBalance`
     * — a split needs a dictionary, and a dictionary gives a different answer
     * per schema and moves names between runs, which is exactly the incidental
     * rename `cheap-regeneration` forbids. So paogen keeps the vendor's
     * spelling, says so on stderr, and the readable name comes from here.
     *
     * These also name the models synthesised for each operation's inline
     * payloads, so one entry buys `getClientFullBalance()` *and*
     * `GetClientFullBalanceResponse` rather than `GetclientfullbalanceResponse`.
     *
     * Three of the thirty-six are absent on purpose. `generate_promocode` and
     * `legal_info` carry real separators, so paogen already reads them as
     * `generatePromocode` and `legalInfo` — listing them here would hide the
     * fact that separator handling works. `goods` is a single word with nothing
     * to split, so paogen reports it and there is nothing to answer with.
     */
    methodRenames: [
        'addclient' => 'addClient',
        'addclienttags' => 'addClientTags',
        'askconfirmphone' => 'askConfirmPhone',
        'blockcard' => 'blockCard',
        'checkconfirmphonecode' => 'checkConfirmPhoneCode',
        'closesession' => 'closeSession',
        'confirmsale' => 'confirmSale',
        'deleteclienttags' => 'deleteClientTags',
        'exchangepossettings' => 'exchangePosSettings',
        'generatecard' => 'generateCard',
        'generategiftcard' => 'generateGiftCard',
        'getactionslist' => 'getActionsList',
        'getclientcards' => 'getClientCards',
        'getclientfullbalance' => 'getClientFullBalance',
        'getclienttags' => 'getClientTags',
        'getconfirmationcode' => 'getConfirmationCode',
        'getdetailingbymove' => 'getDetailingByMove',
        'getlisttags' => 'getListTags',
        'getmovesbyclient' => 'getMovesByClient',
        'getprogramgiftcard' => 'getProgramGiftCard',
        'getprograms' => 'getPrograms',
        'getsalesindicesslides' => 'getSalesIndicesSlides',
        'getwalletlink' => 'getWalletLink',
        'goodslist' => 'goodsList',
        'goodslistxml' => 'goodsListXml',
        'goodsxml' => 'goodsXml',
        'manualadd' => 'manualAdd',
        'processsale' => 'processSale',
        'replacecard' => 'replaceCard',
        'reservedpromocode' => 'reservedPromocode',
        'searchclient' => 'searchClient',
        'searchgiftcard' => 'searchGiftCard',
        'searchpromocode' => 'searchPromocode',
    ],
);
