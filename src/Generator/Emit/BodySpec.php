<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Schema;

/**
 * Resolved request-body shape.
 *
 * Four distinct kinds, each with their own emitter branch:
 *
 *   - KIND_JSON         a Model, by `$ref` or synthesised from an inline
 *                       object, sent as JSON
 *   - KIND_JSON_LIST    `list<Model>`, from either source, sent as JSON
 *   - KIND_JSON_MAP     an inline `type: object` the document left without
 *                       declared properties, sent as JSON — the map is what
 *                       the schema says, so it is what the caller passes
 *   - KIND_FORM         inline `type: object` with declared properties,
 *                       sent as `application/x-www-form-urlencoded`
 *                       (T-011; OAuth2 / Stripe shape)
 *
 * Anything else — `multipart/form-data`, `application/octet-stream`, a content
 * type outside the set, or a form body outside the shape above — never
 * produces a {@see BodySpec} at all: {@see RequestBodyAnalyzer::resolve()}
 * returns null, {@see InlinePayloadPlanner} declines it too, and the caller
 * reports the operation as unrepresentable instead of emitting a method whose
 * body only throws at call time (abort-on-unrepresentable-constructs).
 */
final readonly class BodySpec
{
    public const string KIND_JSON = 'json';
    public const string KIND_JSON_LIST = 'json_list';
    public const string KIND_JSON_MAP = 'json_map';
    public const string KIND_XML = 'xml';
    public const string KIND_XML_LIST = 'xml_list';
    public const string KIND_FORM = 'form_urlencoded';

    /**
     * @param list<FormField> $formFields   non-empty when kind is KIND_FORM
     * @param Schema|null     $schema       the inline node, set when kind is KIND_JSON_MAP so the
     *                                      parameter emitter can type the map's values
     * @param string          $rootElement  the XML root element, set for the XML kinds — the
     *                                      specification supplies no default for it
     * @param string          $itemElement  the repeated XML element, set for KIND_XML_LIST
     */
    public function __construct(
        public string $kind,
        public string $model = '',
        public array $formFields = [],
        public ?Schema $schema = null,
        public string $rootElement = '',
        public string $itemElement = '',
    ) {}

    public static function xml(string $model, string $rootElement): self
    {
        return new self(self::KIND_XML, model: $model, rootElement: $rootElement);
    }

    public static function xmlList(string $model, string $rootElement, string $itemElement): self
    {
        return new self(self::KIND_XML_LIST, model: $model, rootElement: $rootElement, itemElement: $itemElement);
    }

    public static function json(string $model): self
    {
        return new self(self::KIND_JSON, model: $model);
    }

    public static function jsonList(string $model): self
    {
        return new self(self::KIND_JSON_LIST, model: $model);
    }

    public static function jsonMap(Schema $schema): self
    {
        return new self(self::KIND_JSON_MAP, schema: $schema);
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
        return $this->kind === self::KIND_JSON_LIST || $this->kind === self::KIND_XML_LIST;
    }
}
