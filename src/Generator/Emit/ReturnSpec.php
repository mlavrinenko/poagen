<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

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
 */
final readonly class ReturnSpec
{
    public const string KIND_VOID = 'void';
    public const string KIND_MODEL = 'model';
    public const string KIND_LIST = 'list';
    public const string KIND_SCALAR = 'scalar';
    public const string KIND_MAP = 'map';

    public function __construct(
        public string $kind,
        public ?string $model = null,
        public ?string $scalarPhpType = null,
        public ?string $mapValuePhpType = null,
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

    public static function map(string $valuePhpType): self
    {
        return new self(self::KIND_MAP, mapValuePhpType: $valuePhpType);
    }
}
