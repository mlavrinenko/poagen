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
use Mlavrinenko\Paogen\Runtime\Contract\Endpoint;
use Mlavrinenko\Paogen\Runtime\Contract\ResponseType;
use Mlavrinenko\Paogen\Runtime\Contract\TransportInterface;

final readonly class TagsClient implements TagsClientInterface
{
    public function __construct(
        private TransportInterface $transport,
        private string $h,
    ) {
    }

    public function addClientTags(AddClientTagsRequest $body): AddClientTagsResponse
    {
        return $this->transport->send(
            Endpoint::post('/load/addclienttags')->query('h', $this->h)->json($body),
            ResponseType::object(AddClientTagsResponse::class),
        );
    }

    public function deleteClientTags(DeleteClientTagsRequest $body): DeleteClientTagsResponse
    {
        return $this->transport->send(
            Endpoint::post('/load/deleteclienttags')->query('h', $this->h)->json($body),
            ResponseType::object(DeleteClientTagsResponse::class),
        );
    }

    public function getClientTags(GetClientTagsRequest $body): GetClientTagsResponse
    {
        return $this->transport->send(
            Endpoint::post('/load/getclienttags')->query('h', $this->h)->json($body),
            ResponseType::object(GetClientTagsResponse::class),
        );
    }

    public function getListTags(GetListTagsRequest $body): GetListTagsResponse
    {
        return $this->transport->send(
            Endpoint::post('/load/getlisttags')->query('h', $this->h)->json($body),
            ResponseType::object(GetListTagsResponse::class),
        );
    }
}
