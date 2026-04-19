<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ImagesPostAccountTransferAccept implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['recipient_uuid' => ['recipient_uuid', null], 'transfer_id' => ['transfer_id', null]];

    public function __construct(
        public string $recipient_uuid,
        public int $transfer_id,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'recipient_uuid' => $this->recipient_uuid,
            'transfer_id' => $this->transfer_id,
        ];
    }
}
