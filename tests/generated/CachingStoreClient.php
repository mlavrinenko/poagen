<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Generated;

use InvalidArgumentException;
use Mlavrinenko\Paogen\Runtime\Contract\Envelope;
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
    /** @var array<int, Envelope<Order|null>> */
    private array $orders = [];

    public function __construct(
        private readonly StoreClientInterface $inner,
    ) {}

    /**
     * The convenience the generator will not write, mirrored from the
     * committed proof so this twin is the whole shape rather than only the
     * interface's own methods.
     *
     * @return Envelope<Order|null>
     */
    public function refresh(Order $order): Envelope
    {
        $id = $order->id ?? throw new InvalidArgumentException('cannot refresh an Order with no id');
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
