<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

use Acme\Kilbil\Generated\Enum\ExchangePosSettingsResponseRegistrationFieldsBirthDate;
use Acme\Kilbil\Generated\Enum\ExchangePosSettingsResponseRegistrationFieldsDescription;
use Acme\Kilbil\Generated\Enum\ExchangePosSettingsResponseRegistrationFieldsEmail;
use Acme\Kilbil\Generated\Enum\ExchangePosSettingsResponseRegistrationFieldsFirstName;
use Acme\Kilbil\Generated\Enum\ExchangePosSettingsResponseRegistrationFieldsLastName;
use Acme\Kilbil\Generated\Enum\ExchangePosSettingsResponseRegistrationFieldsMiddleName;
use Acme\Kilbil\Generated\Enum\ExchangePosSettingsResponseRegistrationFieldsReferal;
use Acme\Kilbil\Generated\Enum\ExchangePosSettingsResponseRegistrationFieldsSendingPromoMsg;
use Acme\Kilbil\Generated\Enum\ExchangePosSettingsResponseRegistrationFieldsSex;

final readonly class ExchangePosSettingsResponseRegistrationFields
{
    public function __construct(
        public ?ExchangePosSettingsResponseRegistrationFieldsBirthDate $birth_date = null,
        public ?ExchangePosSettingsResponseRegistrationFieldsDescription $description = null,
        public ?ExchangePosSettingsResponseRegistrationFieldsEmail $email = null,
        public ?ExchangePosSettingsResponseRegistrationFieldsFirstName $first_name = null,
        public ?ExchangePosSettingsResponseRegistrationFieldsLastName $last_name = null,
        public ?ExchangePosSettingsResponseRegistrationFieldsMiddleName $middle_name = null,
        public ?ExchangePosSettingsResponseRegistrationFieldsReferal $referal = null,
        public ?ExchangePosSettingsResponseRegistrationFieldsSendingPromoMsg $sending_promo_msg = null,
        public ?ExchangePosSettingsResponseRegistrationFieldsSex $sex = null,
    ) {
    }
}
