<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator;

use Mlavrinenko\Paogen\Runtime\ScalarBinding;

/**
 * Resolves an OpenAPI `format` to a PHP type that is transparent at the wire
 * boundary per `hydration-and-serialization-contract`. Unifies two sources:
 *
 *   - user `#[BindsFormat]` value objects that implement {@see ScalarBinding}
 *     — treated as `scalar` bindings whose `fromScalar()` / `toScalar()`
 *     bracket the wire value on the way in / out;
 *   - paogen-shipped built-ins like `date-time` / `date` → `\DateTimeImmutable`
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

    public function __construct(
        public string $phpType,
        public string $kind,
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
}
