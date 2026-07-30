<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated;

use Acme\Kilbil\Generated\Model\GeneratePromocodeRequest;
use Acme\Kilbil\Generated\Model\GeneratePromocodeResponse;
use Acme\Kilbil\Generated\Model\ReservedPromocodeRequest;
use Acme\Kilbil\Generated\Model\ReservedPromocodeResponse;
use Acme\Kilbil\Generated\Model\SearchPromocodeRequest;
use Acme\Kilbil\Generated\Model\SearchPromocodeResponse;
use Mlavrinenko\Paogen\Runtime\Contract\Endpoint;
use Mlavrinenko\Paogen\Runtime\Contract\ResponseType;
use Mlavrinenko\Paogen\Runtime\Contract\TransportInterface;

final readonly class PromocodesClient implements PromocodesClientInterface
{
    public function __construct(
        private TransportInterface $transport,
        private string $h,
    ) {
    }

    public function generatePromocode(GeneratePromocodeRequest $body): GeneratePromocodeResponse
    {
        return $this->transport->send(
            Endpoint::post('/load/generate_promocode')->query('h', $this->h)->json($body),
            ResponseType::object(GeneratePromocodeResponse::class),
        );
    }

    public function reservedPromocode(ReservedPromocodeRequest $body): ReservedPromocodeResponse
    {
        return $this->transport->send(
            Endpoint::post('/load/reservedpromocode')->query('h', $this->h)->json($body),
            ResponseType::object(ReservedPromocodeResponse::class),
        );
    }

    public function searchPromocode(SearchPromocodeRequest $body): SearchPromocodeResponse
    {
        return $this->transport->send(
            Endpoint::post('/load/searchpromocode')->query('h', $this->h)->json($body),
            ResponseType::object(SearchPromocodeResponse::class),
        );
    }
}
