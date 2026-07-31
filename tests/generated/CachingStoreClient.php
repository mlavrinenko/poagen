<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Generated;

use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\Order;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\StoreClientInterface;

/**
 * A consumer's own class implementing an emitted sub-client interface and
 * holding the generated implementation — the shape of the committed proof at
 * `examples/petstore/src/CachingStoreClient.php`.
 *
 * The whole point is what it does *not* need: no hook, no protected region, no
 * subclassing of a `final` generated class. It implements the contract and
 * delegates, and the caching it adds is behaviour no generated file was edited
 * to allow.
 *
 * Lives in its own file for the same reason as {@see RecordingClient}: the
 * step-stub appender writes into whichever class is last in a file.
 */
final class CachingStoreClient implements StoreClientInterface
{
    /** @var array<int,Order> */
    private array $orders = [];

    public function __construct(
        private readonly StoreClientInterface $inner,
    ) {}

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
