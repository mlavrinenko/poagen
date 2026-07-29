<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\Order;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\StoreClientInterface;
use PHPUnit\Framework\TestCase;

/**
 * The wrapper architecture, exercised rather than asserted about.
 *
 * `examples/petstore/src/CachingStoreClient.php` is the committed proof that a
 * consumer can implement an emitted sub-client interface and delegate to the
 * generated implementation. That file cannot be loaded here — it lives in the
 * example project's own namespace against the example's own generated tree — so
 * this test builds the same shape against the fixture tree and checks the two
 * things a committed file cannot check by existing:
 *
 *   - the interface really is implementable by hand, with no hook, no protected
 *     region and no subclassing of a `final` generated class;
 *   - delegation actually reaches the inner implementation, and a decorator that
 *     caches really does stop it being reached twice.
 *
 * The compile-time half of the proof is the gate's job: `phpstan-generated.neon`
 * analyses every `examples/<name>/src` at max level with nothing suppressed, so the
 * committed decorator failing to satisfy its interface would fail `just check`.
 */
final class DecoratorProofTest extends TestCase
{
    public function testAHandWrittenDecoratorSatisfiesTheEmittedInterface(): void
    {
        $inner = new RecordingStoreClient();
        $decorator = new CountingStoreClient($inner);

        // Type-hinting the interface is the point: consumer code depends on the
        // contract, not on either implementation.
        self::assertInstanceOf(StoreClientInterface::class, $decorator);
        self::assertInstanceOf(StoreClientInterface::class, $inner);
    }

    public function testDelegationReachesTheGeneratedImplementation(): void
    {
        $inner = new RecordingStoreClient();
        $decorator = new CountingStoreClient($inner);

        $order = $decorator->getOrderById(42);

        self::assertSame(42, $order->id);
        self::assertSame([42], $inner->fetched);
    }

    public function testTheDecoratorAddsBehaviourWithoutTouchingTheGeneratedTree(): void
    {
        $inner = new RecordingStoreClient();
        $decorator = new CountingStoreClient($inner);

        $decorator->getOrderById(42);
        $decorator->getOrderById(42);

        // Cached: the second call never reached the inner client. Nothing in the
        // generated tree changed to allow that.
        self::assertSame([42], $inner->fetched);
    }

    public function testAConvenienceMethodMayTakeADomainObjectTheGeneratorWouldNotEmit(): void
    {
        $decorator = new CountingStoreClient(new RecordingStoreClient());

        self::assertSame(7, $decorator->refresh(new Order(id: 7))->id);
    }

    public function testEveryMethodOnTheContractDelegates(): void
    {
        // The whole surface, not just the interesting one: a decorator that
        // silently dropped a call would still satisfy the interface, so the seam
        // is only proven by exercising all of it.
        $inner = new RecordingStoreClient();
        $decorator = new CountingStoreClient($inner);

        self::assertSame([], $decorator->getInventory());
        self::assertSame(3, $decorator->placeOrder(new Order(id: 3))->id);
        self::assertSame([3], $inner->placed);

        $decorator->deleteOrder(3);
        self::assertSame([3], $inner->deleted);

        // Deleting evicted the cache entry `placeOrder` had populated, so the
        // next read reaches the inner client again.
        $decorator->getOrderById(3);
        self::assertSame([3], $inner->fetched);
    }
}

/**
 * Stands in for the generated `StoreClient`. Hand-written here rather than
 * constructed from the emitted class because what is under test is the seam, not
 * the transport — and a test double satisfying the same interface is itself part
 * of what `caller-surface-is-injectable` promises.
 */
final class RecordingStoreClient implements StoreClientInterface
{
    /** @var list<int> */
    public array $fetched = [];

    /** @var list<int> */
    public array $deleted = [];

    /** @var list<int> */
    public array $placed = [];

    public function getOrderById(int $orderId): Order
    {
        $this->fetched[] = $orderId;

        return new Order(id: $orderId);
    }

    public function deleteOrder(int $orderId): void
    {
        $this->deleted[] = $orderId;
    }

    public function placeOrder(Order $body): Order
    {
        if ($body->id !== null) {
            $this->placed[] = $body->id;
        }

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

/**
 * The same shape as the committed `examples/petstore/src/CachingStoreClient.php`.
 */
final class CountingStoreClient implements StoreClientInterface
{
    /** @var array<int,Order> */
    private array $orders = [];

    public function __construct(
        private readonly StoreClientInterface $inner,
    ) {}

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
