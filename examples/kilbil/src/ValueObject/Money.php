<?php

declare(strict_types=1);

namespace Acme\Kilbil\ValueObject;

use InvalidArgumentException;
use Poagen\Runtime\ScalarBinding;

use function get_debug_type;
use function is_float;
use function is_int;
use function number_format;
use function preg_match;

/**
 * A kilbil money amount — no currency, no minor-unit convention declared, so
 * this stores exactly what the vendor sends: a decimal amount with two
 * fractional digits.
 *
 * Kept as a string rather than a float on purpose. `format: double` covers
 * `price`, `quantity`, `bonus_percent` and `purchases_sum` alike, so it
 * cannot carry a document-wide `#[BindsFormat]` the way `Timestamp` or
 * `PhoneNumber` do — a `Money` bound to `double` would type every one of
 * those as money too. `poagen.php`'s `propertyFormats` binds this class to
 * `price` alone, on the two models where the vendor's own description says
 * it is money: `SearchClientRequestContentGoodsDataItem` and
 * `ProcessSaleRequestContentGoodsDataItem` — see the README's "Formats that
 * are mostly not OpenAPI formats" (bind-a-format-per-property).
 */
final readonly class Money implements ScalarBinding
{
    public function __construct(public string $amount)
    {
        if (preg_match('/^-?\d+\.\d{2}$/', $amount) !== 1) {
            throw new InvalidArgumentException(
                "kilbil money expects a decimal amount with two fractional digits, got '{$amount}'",
            );
        }
    }

    public static function fromScalar(mixed $raw): self
    {
        if (!is_float($raw) && !is_int($raw)) {
            throw new InvalidArgumentException(
                'kilbil money expects a numeric payload, got ' . get_debug_type($raw),
            );
        }

        return new self(number_format((float) $raw, 2, '.', ''));
    }

    public function toScalar(): float
    {
        return (float) $this->amount;
    }
}
