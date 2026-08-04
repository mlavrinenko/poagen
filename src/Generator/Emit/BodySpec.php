<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\Schema;

/**
 * Resolved request-body shape.
 *
 * Six distinct kinds, each with their own emitter branch:
 *
 *   - KIND_JSON         a Model, by `$ref` or synthesised from an inline
 *                       object (including one flattened from `allOf`), sent
 *                       as JSON
 *   - KIND_JSON_UNION    an `allOf` whose one `oneOf`/`anyOf` member
 *                       synthesised N branch Models — the parameter is the
 *                       native PHP union across them, sent as JSON as
 *                       whichever branch the caller instantiated (`ruling:
 *                       an anyOf member becomes a union of branches`)
 *   - KIND_JSON_LIST    `list<Model>`, from either source, sent as JSON
 *   - KIND_JSON_MAP     an inline object the document left without declared
 *                       properties, sent as JSON — the map is what the schema
 *                       says, so it is what the caller passes. Object-ness is
 *                       {@see ObjectShape}'s question, not the `type` keyword's:
 *                       a body typed only by `additionalProperties` is one too
 *   - KIND_FORM         inline `type: object` with declared properties,
 *                       sent as `application/x-www-form-urlencoded`
 *                       (T-011; OAuth2 / Stripe shape)
 *   - KIND_XML          a Model synthesised from an inline object declared
 *                       `application/xml`, sent with the root element named
 *                       in `Profile::$xmlElements`
 *   - KIND_XML_LIST     `list<Model>` from an inline array of objects
 *                       declared `application/xml`, sent with the root and
 *                       repeated-item elements both named in
 *                       `Profile::$xmlElements`
 *   - KIND_TEXT         a `type: string` schema under a text content type,
 *                       sent as one `string` argument under the content type
 *                       the document declared first
 *   - KIND_BINARY       `application/octet-stream`, or any `format: binary`
 *                       schema, sent as the PSR-7 stream the caller opened
 *
 * Anything else — `multipart/form-data`, a content type outside the set, a
 * form body outside the shape above, or an XML body whose schema is a
 * `$ref`/scalar/property-less object, or whose element name is missing from
 * `Profile::$xmlElements` — never produces a {@see BodySpec} at all:
 * {@see RequestBodyAnalyzer::resolve()} returns null, {@see
 * InlinePayloadPlanner} declines it too, and the caller reports the operation
 * as unrepresentable instead of emitting a method whose body only throws, or
 * silently degrades, at call time (abort-on-unrepresentable-constructs,
 * default-deny-on-degradation).
 */
final readonly class BodySpec
{
    public const string KIND_JSON = 'json';
    public const string KIND_JSON_UNION = 'json_union';
    public const string KIND_JSON_LIST = 'json_list';
    public const string KIND_JSON_MAP = 'json_map';
    public const string KIND_XML = 'xml';
    public const string KIND_XML_LIST = 'xml_list';
    public const string KIND_FORM = 'form_urlencoded';
    public const string KIND_TEXT = 'text';
    public const string KIND_BINARY = 'binary';

    /**
     * @param list<FormField> $formFields non-empty when kind is KIND_FORM
     * @param Schema|null          $schema           the inline node, set when kind is KIND_JSON_MAP so the
     *                                               parameter emitter can type the map's values
     * @param string               $rootElement      the XML root element, set for the XML kinds — the
     *                                               specification supplies no default for it
     * @param string               $itemElement      the repeated XML element, set for KIND_XML_LIST
     * @param string               $contentType      the content type to send, set for KIND_TEXT and
     *                                               KIND_BINARY — the document declares it and, where it
     *                                               declared several, this is the one poagen picked
     * @param list<string>         $models           the branch class names, set when kind is KIND_JSON_UNION —
     *                                               the parameter type is their `|`-join
     * @param array<string,string> $nestedContainers item-schema property wire name → repeated child element
     *                                               name, set for KIND_XML_LIST when
     *                                               `Profile::$xmlElements` named one of this operation's
     *                                               item properties as a nested container
     *                                               ({@see XmlNestedContainerValidator}). Emitted straight
     *                                               onto the generated `Endpoint::xmlList()` call, which is
     *                                               what carries it to the wire.
     */
    public function __construct(
        public string $kind,
        public string $model = '',
        public array $formFields = [],
        public ?Schema $schema = null,
        public string $rootElement = '',
        public string $itemElement = '',
        public string $contentType = '',
        public array $models = [],
        public array $nestedContainers = [],
    ) {}

    public static function xml(string $model, string $rootElement): self
    {
        return new self(self::KIND_XML, model: $model, rootElement: $rootElement);
    }

    /**
     * @param array<string,string> $nestedContainers
     */
    public static function xmlList(string $model, string $rootElement, string $itemElement, array $nestedContainers = []): self
    {
        return new self(
            self::KIND_XML_LIST,
            model: $model,
            rootElement: $rootElement,
            itemElement: $itemElement,
            nestedContainers: $nestedContainers,
        );
    }

    public static function json(string $model): self
    {
        return new self(self::KIND_JSON, model: $model);
    }

    /**
     * @param list<string> $models at least two branch class names, in
     *                             `oneOf`/`anyOf` declaration order
     */
    public static function jsonUnion(array $models): self
    {
        return new self(self::KIND_JSON_UNION, models: $models);
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

    public static function text(string $contentType): self
    {
        return new self(self::KIND_TEXT, contentType: $contentType);
    }

    public static function binary(string $contentType): self
    {
        return new self(self::KIND_BINARY, contentType: $contentType);
    }

    public function isList(): bool
    {
        return $this->kind === self::KIND_JSON_LIST || $this->kind === self::KIND_XML_LIST;
    }
}
