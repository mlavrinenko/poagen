<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Generated;

use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\Order;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\StoreClientInterface;

/**
 * Stands in for the generated `StoreClient` in the decorator-seam scenario.
 *
 * Hand-written rather than built from the emitted class because what that
 * scenario is about is the seam, not the transport — and a double satisfying
 * the same contract is itself part of what `caller-surface-is-injectable`
 * promises. Records what reached it so the decorator's caching can be shown to
 * have kept a second call away.
 *
 * Lives in its own file so speconaut's step-stub appender does not splice new
 * step methods into it by mistake (it appends to whichever class is last in the
 * target file) — same reason as {@see RecordingClient}.
 */
final class RecordingStoreClient implements StoreClientInterface
{
    /**
     * Order ids that actually reached this client.
     *
     * Only the read path is recorded, because that is the one the scenario
     * calls: a decorator that cached is proven by a second call *not* arriving
     * here.
     *
     * @var list<int>
     */
    public array $fetched = [];

    public function getOrderById(int $orderId): Order
    {
        $this->fetched[] = $orderId;

        return new Order(id: $orderId);
    }

    public function deleteOrder(int $orderId): void {}

    public function placeOrder(Order $body): Order
    {
        return $body;
    }

    /**
     * @return array<string, int>
     */
    public function getInventory(): array
    {
        return [];
    }
}
