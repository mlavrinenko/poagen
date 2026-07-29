<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated;

/**
 * The composition root's contract: one accessor per tag, plus whatever the document left untagged.
 *
 * A service should depend on the sub-client interface it actually needs rather than on this — that grain is the point of the split.
 */
interface ApiClientInterface
{
    /**
     * The `pet` endpoints.
     */
    public function pet(): PetClientInterface;

    /**
     * The `store` endpoints.
     */
    public function store(): StoreClientInterface;

    /**
     * The `user` endpoints.
     */
    public function user(): UserClientInterface;
}
