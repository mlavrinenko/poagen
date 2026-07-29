<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

/**
 * Resolved request-body shape.
 *
 * Three distinct kinds, each with their own emitter branch:
 *
 *   - KIND_JSON         `$ref`-to-Model, sent as JSON
 *   - KIND_JSON_LIST    `list<$ref>`, sent as JSON
 *   - KIND_FORM         inline `type: object` with declared properties,
 *                       sent as `application/x-www-form-urlencoded`
 *                       (T-011; OAuth2 / Stripe shape)
 *
 * Anything else — `multipart/form-data`, `application/octet-stream`, an
 * inline JSON body, or a form body outside the shape above — never
 * produces a {@see BodySpec} at all: {@see RequestBodyAnalyzer::resolve()}
 * returns null and the caller reports the operation as unrepresentable
 * instead of emitting a method whose body only throws at call time
 * (abort-on-unrepresentable-constructs).
 */
final readonly class BodySpec
{
    public const string KIND_JSON = 'json';
    public const string KIND_JSON_LIST = 'json_list';
    public const string KIND_FORM = 'form_urlencoded';

    /**
     * @param list<FormField> $formFields non-empty when kind is KIND_FORM
     */
    public function __construct(
        public string $kind,
        public string $model = '',
        public array $formFields = [],
    ) {}

    public static function json(string $model): self
    {
        return new self(self::KIND_JSON, model: $model);
    }

    public static function jsonList(string $model): self
    {
        return new self(self::KIND_JSON_LIST, model: $model);
    }

    /**
     * @param list<FormField> $fields
     */
    public static function form(array $fields): self
    {
        return new self(self::KIND_FORM, formFields: $fields);
    }

    public function isList(): bool
    {
        return $this->kind === self::KIND_JSON_LIST;
    }
}
