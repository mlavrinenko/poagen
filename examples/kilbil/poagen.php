<?php

declare(strict_types=1);

use Poagen\Generator\Generator\Profile;

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
     * Where poagen looks for this project's own `#[BindsFormat]` value objects.
     * The vendor writes nine format values across 292 uses and poagen knows one
     * of them, so it reports the other eight and `src/ValueObject/` answers the
     * four that carry meaning: `date time` and `data time` (both `date-time`
     * misspelled), `data` (`date` misspelled), and the invented `phone`.
     *
     * `int` and `double` stay unbound document-wide, and for `int` that is the
     * whole story: a `#[BindsFormat]` binds a format string everywhere it
     * appears, and `int` here means several unrelated counters. `double` is
     * mostly the same — price, quantity, percentages and balances alike — but
     * `propertyFormats` below answers the one place a `double` is
     * unambiguously money, without touching the rest. `Money` therefore lives
     * in this same namespace but carries no `#[BindsFormat]` of its own: it
     * opts in per property, not per format. See the README's "Formats that
     * are mostly not OpenAPI formats" for the reasoning this replaced.
     */
    discoverIn: [
        'Acme\\Kilbil\\ValueObject',
    ],

    /*
     * `goods_data/items/properties/price` — "цена без скидки за единицу
     * номенклатуры" ("price per unit, before discount") — is unambiguously
     * money, named as such by the vendor's own description, on the two
     * inline request-body shapes that carry it. Neither is a named
     * component (`components.schemas` is empty in this document — "No named
     * components at all" in the README), so each is keyed by the class name
     * poagen assigns it rather than by a raw schema key
     * (bind-a-format-per-property). Every other `double`-typed field in this
     * document — `price1`..`price5`, `discounted_price`, `bonus_percent`,
     * `purchases_sum`, the response-side echoes of this same `price` — stays
     * a plain `float`: the vendor did not say those are money, and guessing
     * would be exactly the kind of inference `cheap-regeneration` forbids.
     */
    propertyFormats: [
        'SearchClientRequestContentGoodsDataItem.price' => \Acme\Kilbil\ValueObject\Money::class,
        'ProcessSaleRequestContentGoodsDataItem.price' => \Acme\Kilbil\ValueObject\Money::class,
    ],

    /*
     * All eleven tags are Russian words, and a tag names a sub-client class.
     * Without an answer here poagen transliterates deterministically —
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
     * and this document carries no `xml:` metadata at all. poagen refuses to
     * invent either, because a wrong root element is a 400 from the vendor.
     *
     * poagen could not confirm these with a live call — the example still makes
     * none — but the vendor document already had the answer. Both operations'
     * `application/xml` request body in schemas/loyalty_v1.yaml carries a
     * literal `example: |` block with a full XML sample: around line 4305, the
     * `/load/goodsxml` request body shows root `<goods>` with repeated item
     * `<good>`; around line 4570, the `/load/goodslistxml` request body shows
     * root `<goodslist>` with repeated item `<goodlist>` — not `good`, which is
     * what this mapping said until this change.
     *
     * Both samples nest one level further: a `<good>`/`<goodlist>` item can
     * contain an `<inside>` wrapper holding more `<good>`/`<goodlist>` children,
     * mirroring the schema's own `inside` array property — the two
     * `'<operationId>.item.inside'` entries below name that wrapper's repeated
     * child the same way `'<operationId>.item'` names the outer one. A binding
     * naming a property absent from the item schema fails the run, the same as
     * a stale root or item entry would (kilbil-xml-nesting-is-unrepresentable).
     *
     * poagen validates these entries against the schema and wires them onto
     * the generated call: `goodsXml()` and `goodsListXml()` emit
     * `->xmlList($body, root, item, ['inside' => child])`, so a caller who
     * passes a populated `inside` gets the vendor's nested shape with no
     * further wiring — no `XmlWriter` to construct, no map to keep in step by
     * hand (thread-the-validated-nested-container-map-into-the-generated-client).
     *
     * See README.md, and
     * tests/Integration/Kilbil/KilbilXmlNestedContainerTest.php for the emitted
     * XML compared against these same vendor samples.
     */
    xmlElements: [
        'goodsxml' => 'goods',
        'goodsxml.item' => 'good',
        'goodsxml.item.inside' => 'good',
        'goodslistxml' => 'goodslist',
        'goodslistxml.item' => 'goodlist',
        'goodslistxml.item.inside' => 'goodlist',
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
     * rename `cheap-regeneration` forbids. So poagen keeps the vendor's
     * spelling, says so on stderr, and the readable name comes from here.
     *
     * These also name the models synthesised for each operation's inline
     * payloads, so one entry buys `getClientFullBalance()` *and*
     * `GetClientFullBalanceResponse` rather than `GetclientfullbalanceResponse`.
     *
     * Three of the thirty-six are absent on purpose. `generate_promocode` and
     * `legal_info` carry real separators, so poagen already reads them as
     * `generatePromocode` and `legalInfo` — listing them here would hide the
     * fact that separator handling works. `goods` is a single word with nothing
     * to split, so poagen reports it and there is nothing to answer with.
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
