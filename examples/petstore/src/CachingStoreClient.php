<?php

declare(strict_types=1);

namespace Acme\Petstore;

use Acme\Petstore\Generated\Model\Order;
use Acme\Petstore\Generated\StoreClientInterface;

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
 * PSR-18 handler (ADR-002), not here.
 */
final class CachingStoreClient implements StoreClientInterface
{
    /** @var array<int,Order> */
    private array $orders = [];

    public function __construct(
        private readonly StoreClientInterface $inner,
    ) {}

    /**
     * The convenience the generator will not write: callers holding an `Order`
     * should not have to unpack an id to refresh it.
     */
    public function refresh(Order $order): Order
    {
        $id = $order->id ?? throw new \InvalidArgumentException('cannot refresh an Order with no id');
        unset($this->orders[$id]);

        return $this->getOrderById($id);
    }

    public function getOrderById(int $orderId): Order
    {
        return $this->orders[$orderId] ??= $this->inner->getOrderById($orderId);
    }

    public function deleteOrder(int $orderId): void
    {
        $this->inner->deleteOrder($orderId);
        unset($this->orders[$orderId]);
    }

    public function placeOrder(Order $body): Order
    {
        $placed = $this->inner->placeOrder($body);

        if ($placed->id !== null) {
            $this->orders[$placed->id] = $placed;
        }

        return $placed;
    }

    /**
     * @return array<string, int>
     */
    public function getInventory(): array
    {
        return $this->inner->getInventory();
    }
}
