<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated;

use Acme\Kilbil\Generated\Model\GetWalletLinkRequest;
use Acme\Kilbil\Generated\Model\GetWalletLinkResponse;
use Mlavrinenko\Paogen\Runtime\Contract\Endpoint;
use Mlavrinenko\Paogen\Runtime\Contract\ResponseType;
use Mlavrinenko\Paogen\Runtime\Contract\TransportInterface;

final readonly class WalletClient implements WalletClientInterface
{
    public function __construct(
        private TransportInterface $transport,
        private string $h,
    ) {
    }

    public function getWalletLink(GetWalletLinkRequest $body): GetWalletLinkResponse
    {
        return $this->transport->send(
            Endpoint::post('/load/getwalletlink')->query('h', $this->h)->json($body),
            ResponseType::object(GetWalletLinkResponse::class),
        );
    }
}
