<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

use Acme\Kilbil\Generated\Enum\AddClientRequestNotToSendEmail;
use Acme\Kilbil\Generated\Enum\AddClientRequestNotToSendSms;
use Acme\Kilbil\Generated\Enum\AddClientRequestOuterSystemsInterfaceType;
use Acme\Kilbil\Generated\Enum\AddClientRequestSex;
use Acme\Kilbil\ValueObject\CalendarDate;
use Acme\Kilbil\ValueObject\PhoneNumber;
use Acme\Kilbil\ValueObject\Timestamp;

final readonly class AddClientRequest
{
    /**
     * @param ?list<AddClientRequestSpecialDaysItem> $special_days
     */
    public function __construct(
        public ?int $client_id,
        public PhoneNumber $phone,
        public ?CalendarDate $birth_date = null,
        public ?string $card_barcode = null,
        public ?string $card_code = null,
        public ?string $email = null,
        public ?string $first_name = null,
        public ?string $last_name = null,
        public ?string $middle_name = null,
        public ?AddClientRequestNotToSendEmail $not_to_send_email = null,
        public ?AddClientRequestNotToSendSms $not_to_send_sms = null,
        public ?AddClientRequestOuterSystemsInterfaceType $outer_systems_interface_type = null,
        public ?string $promo_code = null,
        public ?int $referrer_client_id = null,
        public ?AddClientRequestSex $sex = null,
        public ?Timestamp $shift_open_dt = null,
        public ?array $special_days = null,
    ) {
    }
}
