<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated;

use Acme\Kilbil\Generated\Model\GoodsListRequestItem;
use Acme\Kilbil\Generated\Model\GoodsListResponse;
use Acme\Kilbil\Generated\Model\GoodsListXmlRequestItem;
use Acme\Kilbil\Generated\Model\GoodsListXmlResponse;
use Acme\Kilbil\Generated\Model\GoodsRequestItem;
use Acme\Kilbil\Generated\Model\GoodsResponse;
use Acme\Kilbil\Generated\Model\GoodsXmlRequestItem;
use Acme\Kilbil\Generated\Model\GoodsXmlResponse;

/**
 * The contract for the `Номенклатура` endpoints.
 *
 * Type-hint this rather than the class: hand-written convenience implements the same
 * contract and delegates to the generated implementation, so a regeneration that changes
 * the surface fails to compile instead of silently breaking the seam.
 */
interface CatalogueClientInterface
{
    /**
     * @param list<\Acme\Kilbil\Generated\Model\GoodsRequestItem> $body
     */
    public function goods(array $body, ?int $partial = null, ?int $id = null): GoodsResponse;

    /**
     * @param list<\Acme\Kilbil\Generated\Model\GoodsListRequestItem> $body
     */
    public function goodsList(array $body, ?int $id = null): GoodsListResponse;

    /**
     * @param list<\Acme\Kilbil\Generated\Model\GoodsListXmlRequestItem> $body
     */
    public function goodsListXml(array $body, ?int $id = null): GoodsListXmlResponse;

    /**
     * @param list<\Acme\Kilbil\Generated\Model\GoodsXmlRequestItem> $body
     */
    public function goodsXml(array $body, ?int $partial = null, ?int $id = null): GoodsXmlResponse;
}
