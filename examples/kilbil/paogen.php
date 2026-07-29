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
