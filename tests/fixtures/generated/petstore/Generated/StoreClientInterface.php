<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated;

use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\Order;

/**
 * The contract for the `store` endpoints.
 *
 * Type-hint this rather than the class: hand-written convenience implements the same
 * contract and delegates to the generated implementation, so a regeneration that changes
 * the surface fails to compile instead of silently breaking the seam.
 */
interface StoreClientInterface
{
    /**
     * @return array<string, int>
     */
    public function getInventory(): array;

    public function placeOrder(Order $body): Order;

    public function getOrderById(int $orderId): Order;

    public function deleteOrder(int $orderId): void;
}
