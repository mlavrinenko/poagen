<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator;

use Poagen\Runtime\Codec;
use Poagen\Runtime\ScalarBinding;

use function in_array;
use function ltrim;

/**
 * Resolves an OpenAPI `format` to a PHP type that is transparent at the wire
 * boundary per `hydration-and-serialization-contract`. Unifies three sources:
 *
 *   - user `#[BindsFormat]` value objects that implement {@see ScalarBinding}
 *     — treated as `scalar` bindings whose `fromScalar()` / `toScalar()`
 *     bracket the wire value on the way in / out;
 *   - a class implementing {@see Codec} — treated as a `codec` binding: the
 *     property is declared as the codec's *target* type, a type poagen does
 *     not require to implement anything, and conversion runs through the
 *     codec instead of through the property's own type
 *     (`codec-bindings-for-foreign-value-types`);
 *   - poagen-shipped built-ins like `date-time` / `date` → `\DateTimeImmutable`
 *     — the generator hard-codes the marshal/unmarshal expressions.
 *
 * A built-in is overridden by a user binding on the same format, so library
 * consumers remain free to swap `\DateTimeImmutable` for Carbon.
 */
final readonly class ScalarFormat
{
    public const string KIND_SCALAR = 'scalar';
    public const string KIND_DATETIME = 'datetime';
    public const string KIND_DATE = 'date';
    public const string KIND_CODEC = 'codec';

    private const array BUILTIN_TARGET_TYPES = ['string', 'int', 'float', 'bool'];

    public function __construct(
        public string $phpType,
        public string $kind,
        public ?string $codecClass = null,
    ) {}

    /**
     * @param class-string<ScalarBinding> $fqcn
     */
    public static function userScalar(string $fqcn): self
    {
        return new self('\\' . ltrim($fqcn, '\\'), self::KIND_SCALAR);
    }

    public static function dateTime(): self
    {
        return new self('\DateTimeImmutable', self::KIND_DATETIME);
    }

    public static function date(): self
    {
        return new self('\DateTimeImmutable', self::KIND_DATE);
    }

    /**
     * `$targetType` is whatever {@see Codec::targetType()} answered for
     * `$codec` — a class-string, or one of PHP's own scalar type names. Only
     * the class-string case gets the leading backslash a PHP type
     * declaration needs; `'string'` stays `'string'`.
     *
     * @param class-string<Codec> $codec
     */
    public static function codec(string $codec, string $targetType): self
    {
        $phpType = in_array($targetType, self::BUILTIN_TARGET_TYPES, true)
            ? $targetType
            : '\\' . ltrim($targetType, '\\');

        return new self($phpType, self::KIND_CODEC, $codec);
    }
}
