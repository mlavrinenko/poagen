<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated;

use Mlavrinenko\Paogen\Runtime\Contract\TransportInterface;

final readonly class ApiClient implements ApiClientInterface
{
    public function __construct(
        private TransportInterface $transport,
    ) {
    }

    /**
     * The `pet` endpoints.
     */
    public function pet(): PetClientInterface
    {
        return new PetClient($this->transport);
    }

    /**
     * The `store` endpoints.
     */
    public function store(): StoreClientInterface
    {
        return new StoreClient($this->transport);
    }

    /**
     * The `user` endpoints.
     */
    public function user(): UserClientInterface
    {
        return new UserClient($this->transport);
    }
}
