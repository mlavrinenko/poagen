<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated;

use Mlavrinenko\Paogen\Runtime\Contract\Endpoint;
use Mlavrinenko\Paogen\Runtime\Contract\ResponseType;
use Mlavrinenko\Paogen\Runtime\Contract\TransportInterface;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\Order;

final readonly class StoreClient implements StoreClientInterface
{
    public function __construct(
        private TransportInterface $transport,
    ) {
    }

    /**
     * @return array<string, int>
     */
    public function getInventory(): array
    {
        return $this->transport->send(
            Endpoint::get('/store/inventory'),
            ResponseType::mapOf(ResponseType::int()),
        );
    }

    public function placeOrder(Order $body): Order
    {
        return $this->transport->send(
            Endpoint::post('/store/order')->json($body),
            ResponseType::object(Order::class),
        );
    }

    public function getOrderById(int $orderId): Order
    {
        return $this->transport->send(
            Endpoint::get('/store/order/{orderId}')->path('orderId', $orderId),
            ResponseType::object(Order::class),
        );
    }

    public function deleteOrder(int $orderId): void
    {
        $this->transport->send(
            Endpoint::delete('/store/order/{orderId}')->path('orderId', $orderId),
            ResponseType::nothing(),
        );
    }
}
