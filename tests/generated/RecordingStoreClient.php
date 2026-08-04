<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Generated;

use Mlavrinenko\Paogen\Runtime\Contract\Envelope;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\Order;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\StoreClientInterface;
use Nyholm\Psr7\Response;

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

    /**
     * @return Envelope<Order|null>
     */
    public function getOrderById(int $orderId): Envelope
    {
        $this->fetched[] = $orderId;

        return new Envelope(200, new Order(id: $orderId), new Response());
    }

    /**
     * @return Envelope<null>
     */
    public function deleteOrder(int $orderId): Envelope
    {
        return new Envelope(200, null, new Response());
    }

    /**
     * @return Envelope<Order|null>
     */
    public function placeOrder(Order $body): Envelope
    {
        return new Envelope(200, $body, new Response());
    }

    /**
     * @return Envelope<array<string, int>|null>
     */
    public function getInventory(): Envelope
    {
        return new Envelope(200, [], new Response());
    }
}
