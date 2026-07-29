<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated;

use Acme\Kilbil\Generated\Model\AddClientTagsRequest;
use Acme\Kilbil\Generated\Model\AddClientTagsResponse;
use Acme\Kilbil\Generated\Model\DeleteClientTagsRequest;
use Acme\Kilbil\Generated\Model\DeleteClientTagsResponse;
use Acme\Kilbil\Generated\Model\GetClientTagsRequest;
use Acme\Kilbil\Generated\Model\GetClientTagsResponse;
use Acme\Kilbil\Generated\Model\GetListTagsRequest;
use Acme\Kilbil\Generated\Model\GetListTagsResponse;

/**
 * The contract for the `Теги` endpoints.
 *
 * Type-hint this rather than the class: hand-written convenience implements the same
 * contract and delegates to the generated implementation, so a regeneration that changes
 * the surface fails to compile instead of silently breaking the seam.
 */
interface TagsClientInterface
{
    public function addClientTags(AddClientTagsRequest $body): AddClientTagsResponse;

    public function deleteClientTags(DeleteClientTagsRequest $body): DeleteClientTagsResponse;

    public function getClientTags(GetClientTagsRequest $body): GetClientTagsResponse;

    public function getListTags(GetListTagsRequest $body): GetListTagsResponse;
}
