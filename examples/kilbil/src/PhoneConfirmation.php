<?php

declare(strict_types=1);

namespace Acme\Kilbil;

use Acme\Kilbil\Generated\ConfirmationCodesClientInterface;
use Acme\Kilbil\Generated\Model\AskConfirmPhone200Content;
use Acme\Kilbil\Generated\Model\AskConfirmPhone403Content;
use Acme\Kilbil\Generated\Model\AskConfirmPhoneRequestContent;
use Acme\Kilbil\Generated\Model\CheckConfirmPhoneCode200Content;
use Acme\Kilbil\Generated\Model\CheckConfirmPhoneCode403Content;
use Acme\Kilbil\Generated\Model\CheckConfirmPhoneCodeRequestContent;
use Acme\Kilbil\ValueObject\PhoneNumber;
use Poagen\Runtime\Contract\Envelope;

/**
 * The wrapper architecture on the acceptance target.
 *
 * This is hand-written consumer code. It implements
 * `ConfirmationCodesClientInterface` — the contract poagen emitted for the
 * vendor's `Код подтверждения` tag — delegates both calls to the generated
 * implementation, and adds a method the generator has no way to write: one that
 * takes a phone number and a code and returns whether the code was accepted,
 * instead of two request objects and two response objects.
 *
 * Four things make it the proof `kilbil-loyalty-client-proof` asks for.
 *
 * Nothing in `generated/` changed to allow it. No hook, no protected region, no
 * subclass of a `final` class — `generated-types-are-total` forbids all three and
 * this needs none.
 *
 * The seam is compiler-checked. Rename `checkConfirmPhoneCode` upstream, or change
 * its signature, and this class stops satisfying the interface and the build says
 * so. `just lint-phpstan-generated` analyses this directory at max level with no
 * baseline and nothing ignored, so that check is part of the gate rather than a
 * promise.
 *
 * The dependency is grained. This decorates two endpoints, not thirty-six, so a
 * unit test faking it stands in for two methods.
 *
 * And the vendor's awkwardness stays outside the emitted tree. `PhoneNumber` is
 * this project's own value object, bound to the vendor's invented `format: phone`
 * from `poagen.php`; the generated models carry it because the profile said to,
 * not because poagen knows anything about Russian phone numbers.
 */
final class PhoneConfirmation implements ConfirmationCodesClientInterface
{
    public function __construct(
        private readonly ConfirmationCodesClientInterface $inner,
    ) {}

    /**
     * The convenience the generator will not write: two objects in and two
     * objects out becomes a phone number, a code, and a yes or no.
     */
    public function isCodeValid(PhoneNumber $phone, string $code, ?int $clientId = null): bool
    {
        $response = $this->checkConfirmPhoneCode(new CheckConfirmPhoneCodeRequestContent(
            client_id: $clientId,
            phone: $phone,
            code: $code,
        ));

        // The vendor's 403 carries no `result_code` worth trusting as a
        // success flag — narrowing to the 200 body first is what
        // `typed-error-responses` bought over the old thrown `ApiException`:
        // a declared 403 is a value to check, not a branch that unwound
        // the call before this method got to look at anything.
        if (!$response->body instanceof CheckConfirmPhoneCode200Content) {
            return false;
        }

        // The vendor signals success in a `result_code` — declared `type: string`,
        // so `'0'` and not `0` — rather than in the HTTP status. That is exactly
        // the kind of local knowledge that belongs here and not in generated code:
        // poagen emitted the field faithfully and has no idea what its values mean.
        return $response->body->result_code === '0';
    }

    /**
     * @return Envelope<AskConfirmPhone200Content|AskConfirmPhone403Content>
     */
    public function askConfirmPhone(AskConfirmPhoneRequestContent $body): Envelope
    {
        return $this->inner->askConfirmPhone($body);
    }

    /**
     * @return Envelope<CheckConfirmPhoneCode200Content|CheckConfirmPhoneCode403Content>
     */
    public function checkConfirmPhoneCode(CheckConfirmPhoneCodeRequestContent $body): Envelope
    {
        return $this->inner->checkConfirmPhoneCode($body);
    }
}
