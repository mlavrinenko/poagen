<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use Mlavrinenko\Paogen\Runtime\Contract\ResponseType;

/**
 * Resolved return-type of an operation.
 *
 * The kind discriminates how the emitter shapes both the PHP return type
 * and the response-decoding body:
 *   - `void`   → no 2xx JSON response
 *   - `model`  → `$ref`-to-component, hydrated
 *   - `list`   → `array` of `$ref`-to-component, each hydrated
 *   - `scalar` → returned via `(scalar) $response->getBody()` (no decode)
 *   - `map`    → `additionalProperties`, returned as the decoded array
 *   - `mixed`  → the document declared nothing here, so neither does the type
 *
 * A map carries the shape of its *values* as another spec rather than as a
 * type name, which is what lets `additionalProperties: {$ref: Pet}` answer
 * `array<string, Pet>` and a nested map answer
 * `array<string, array<string, string>>`. The request side already resolved
 * both through {@see TypeResolver}; a flat value-type string was the whole
 * reason the response side could only answer `mixed`. It mirrors
 * {@see ResponseType}, which has carried
 * a nested value shape all along.
 *
 * `mixed` is reachable only as a map's value: an operation never returns a
 * bare `mixed`, because a response the emitter cannot represent is refused
 * rather than widened (default-deny-on-degradation).
 */
final readonly class ReturnSpec
{
    public const string KIND_VOID = 'void';
    public const string KIND_MODEL = 'model';
    public const string KIND_LIST = 'list';
    public const string KIND_SCALAR = 'scalar';
    public const string KIND_MAP = 'map';
    public const string KIND_MIXED = 'mixed';

    public function __construct(
        public string $kind,
        public ?string $model = null,
        public ?string $scalarPhpType = null,
        public ?self $mapValue = null,
    ) {}

    public static function void(): self
    {
        return new self(self::KIND_VOID);
    }

    public static function model(string $name): self
    {
        return new self(self::KIND_MODEL, model: $name);
    }

    public static function listOf(string $name): self
    {
        return new self(self::KIND_LIST, model: $name);
    }

    public static function scalar(string $phpType): self
    {
        return new self(self::KIND_SCALAR, scalarPhpType: $phpType);
    }

    /**
     * A string-keyed map whose values have the given shape.
     */
    public static function map(self $value): self
    {
        return new self(self::KIND_MAP, mapValue: $value);
    }

    /**
     * A value the document left unconstrained.
     */
    public static function mixed(): self
    {
        return new self(self::KIND_MIXED);
    }
}
