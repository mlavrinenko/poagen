<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

use Acme\Kilbil\Generated\Enum\AskConfirmPhoneRequestSendType;
use Acme\Kilbil\Generated\Enum\AskConfirmPhoneRequestSmsType;
use Acme\Kilbil\ValueObject\PhoneNumber;

final readonly class AskConfirmPhoneRequest
{
    public function __construct(
        public ?int $client_id,
        public PhoneNumber $phone,
        public ?AskConfirmPhoneRequestSendType $send_type = null,
        public ?AskConfirmPhoneRequestSmsType $sms_type = null,
    ) {
    }
}
