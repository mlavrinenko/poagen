<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use InvalidArgumentException;
use Mlavrinenko\Paogen\Runtime\Contract\Envelope;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\Order;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\StoreClientInterface;
use Nyholm\Psr7\Response;
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

        self::assertSame(42, $order->body?->id);
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

        self::assertSame(7, $decorator->refresh(new Order(id: 7))->body?->id);
    }

    public function testEveryMethodOnTheContractDelegates(): void
    {
        // The whole surface, not just the interesting one: a decorator that
        // silently dropped a call would still satisfy the interface, so the seam
        // is only proven by exercising all of it.
        $inner = new RecordingStoreClient();
        $decorator = new CountingStoreClient($inner);

        self::assertSame([], $decorator->getInventory()->body);
        self::assertSame(3, $decorator->placeOrder(new Order(id: 3))->body?->id);
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
        $this->deleted[] = $orderId;

        return new Envelope(200, null, new Response());
    }

    /**
     * @return Envelope<Order|null>
     */
    public function placeOrder(Order $body): Envelope
    {
        if ($body->id !== null) {
            $this->placed[] = $body->id;
        }

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

/**
 * The same shape as the committed `examples/petstore/src/CachingStoreClient.php`.
 */
final class CountingStoreClient implements StoreClientInterface
{
    /** @var array<int, Envelope<Order|null>> */
    private array $orders = [];

    public function __construct(
        private readonly StoreClientInterface $inner,
    ) {}

    /**
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
