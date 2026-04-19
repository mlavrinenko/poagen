<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

/**
 * Resolved request-body shape.
 *
 * Four distinct kinds, each with their own emitter branch:
 *
 *   - KIND_JSON         `$ref`-to-Model, sent as JSON
 *   - KIND_JSON_LIST    `list<$ref>`, sent as JSON
 *   - KIND_FORM         inline `type: object` with declared properties,
 *                       sent as `application/x-www-form-urlencoded`
 *                       (T-011; OAuth2 / Stripe shape)
 *   - KIND_UNSUPPORTED  `multipart/form-data` or `application/octet-stream`;
 *                       method is emitted but its body throws
 *                       `\RuntimeException` — runtime TODO(multipart)
 */
final readonly class BodySpec
{
    public const string KIND_JSON = 'json';
    public const string KIND_JSON_LIST = 'json_list';
    public const string KIND_FORM = 'form_urlencoded';
    public const string KIND_UNSUPPORTED = 'unsupported';

    /**
     * @param list<FormField> $formFields              non-empty when kind is KIND_FORM
     * @param string          $unsupportedContentType  non-empty when kind is KIND_UNSUPPORTED
     */
    public function __construct(
        public string $kind,
        public string $model = '',
        public array $formFields = [],
        public string $unsupportedContentType = '',
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

    public static function unsupported(string $contentType): self
    {
        return new self(self::KIND_UNSUPPORTED, unsupportedContentType: $contentType);
    }

    public function isList(): bool
    {
        return $this->kind === self::KIND_JSON_LIST;
    }
}
