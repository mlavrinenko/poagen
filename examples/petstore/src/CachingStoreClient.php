<?php

declare(strict_types=1);

namespace Acme\Petstore;

use Acme\Petstore\Generated\Model\Order;
use Acme\Petstore\Generated\StoreClientInterface;
use Mlavrinenko\Paogen\Runtime\Contract\Envelope;

/**
 * The wrapper architecture, demonstrated.
 *
 * This is hand-written consumer code. It implements the interface paogen emitted
 * for the `store` tag, delegates every call to the generated implementation, and
 * adds two things the generator has no business knowing about: a per-instance
 * cache of orders already fetched, and a convenience method that takes a domain
 * object instead of an integer.
 *
 * Three properties are what make it a proof rather than a demo.
 *
 * Nothing in the generated tree changed to allow it. There is no hook, no
 * protected region, no subclass — `generated-types-are-total` forbids all three,
 * and this needs none of them.
 *
 * The seam is compiler-checked. If a regeneration renames `getOrderById`, drops
 * it, or changes its signature, this class stops satisfying
 * `StoreClientInterface` and the build says so. That is the whole reason the
 * generator emits an interface at all: `caller-surface-is-injectable` puts the
 * contract where the compiler can see it, so regeneration cannot silently break
 * the seam.
 *
 * The dependency is grained. This decorates the four `store` endpoints, not all
 * nineteen in the document, so a test double for it stands in for four methods.
 *
 * Note what is deliberately absent: retries, backoff, logging, authentication.
 * Those are transport concerns and compose underneath the client through the
 * PSR-18 handler (`no-inheritance-no-protected-regions`), not here.
 */
final class CachingStoreClient implements StoreClientInterface
{
    /** @var array<int, Envelope<Order|null>> */
    private array $orders = [];

    public function __construct(
        private readonly StoreClientInterface $inner,
    ) {}

    /**
     * The convenience the generator will not write: callers holding an `Order`
     * should not have to unpack an id to refresh it.
     *
     * @return Envelope<Order|null>
     */
    public function refresh(Order $order): Envelope
    {
        $id = $order->id ?? throw new \InvalidArgumentException('cannot refresh an Order with no id');
        unset($this->orders[$id]);

        return $this->getOrderById($id);
    }

    /**
     * @return Envelope<Order|null>
     */
    public function getOrderById(int $orderId): Envelope
    {
        return $this->orders[$orderId] ??= $this->inner->getOrderById($orderId);
    }

    /**
     * @return Envelope<null>
     */
    public function deleteOrder(int $orderId): Envelope
    {
        $result = $this->inner->deleteOrder($orderId);
        unset($this->orders[$orderId]);

        return $result;
    }

    /**
     * @return Envelope<Order|null>
     */
    public function placeOrder(Order $body): Envelope
    {
        $placed = $this->inner->placeOrder($body);

        if ($placed->body instanceof Order && $placed->body->id !== null) {
            $this->orders[$placed->body->id] = $placed;
        }

        return $placed;
    }

    /**
     * @return Envelope<array<string, int>|null>
     */
    public function getInventory(): Envelope
    {
        return $this->inner->getInventory();
    }
}
