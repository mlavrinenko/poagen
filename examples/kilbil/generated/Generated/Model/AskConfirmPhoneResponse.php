<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

use Acme\Kilbil\Generated\Enum\AskConfirmPhoneResponseTypeConfirmationCode;

final readonly class AskConfirmPhoneResponse
{
    public function __construct(
        public string $result_code,
        public string $result_text,
        public ?int $success = null,
        public ?AskConfirmPhoneResponseTypeConfirmationCode $type_confirmation_code = null,
    ) {
    }
}
