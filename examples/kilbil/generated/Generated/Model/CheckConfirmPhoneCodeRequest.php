<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

use Acme\Kilbil\ValueObject\PhoneNumber;

final readonly class CheckConfirmPhoneCodeRequest
{
    public function __construct(
        public ?int $client_id,
        public PhoneNumber $phone,
        public ?string $code = null,
    ) {
    }
}
