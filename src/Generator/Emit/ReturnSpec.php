<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use Mlavrinenko\Paogen\Generator\Bindings;
use Mlavrinenko\Paogen\Generator\ScalarFormat;
use Mlavrinenko\Paogen\Runtime\Contract\ResponseType;

/**
 * Resolved return-type of an operation.
 *
 * The kind discriminates how the emitter shapes both the PHP return type
 * and the response-decoding body:
 *   - `void`        → no 2xx JSON response
 *   - `model`       → `$ref`-to-component, hydrated
 *   - `list`        → `array` of `$ref`-to-component, each hydrated
 *   - `scalar`      → returned via `(scalar) $response->getBody()` (no decode)
 *   - `scalar_list` → `array` of scalars, decoded but never hydrated
 *   - `map`         → `additionalProperties`, returned as the decoded array
 *   - `mixed`       → the document declared nothing here, so neither does the type
 *   - `stream`      → `format: binary`, the PSR-7 body handed back unread
 *
 * `scalar_list` exists because every other list shape resolves a class name
 * and hydrates it, so `items: {type: string}` — which GitHub declares on
 * three operations — had no way to be said at all. It carries its item as
 * another spec rather than as a type name, for the same reason a map does:
 * an item can be a plain scalar or a scalar the document gave a `format`
 * paogen binds to a type, and a flat string could not tell those apart.
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
    public const string KIND_SCALAR_LIST = 'scalar_list';
    public const string KIND_MAP = 'map';
    public const string KIND_MIXED = 'mixed';

    /**
     * A body the document declared binary — `format: binary`, under any
     * content type — carried back as the PSR-7 `StreamInterface` the
     * transport produced, never read. Mirrors `BodySpec::KIND_BINARY` on the
     * request side: the same shape, the same reason (PHP has no `resource`
     * type declaration, and `declared-shapes-become-types` forbids a
     * declared shape becoming `mixed`), just the other direction
     * (`a-binary-body-is-a-psr-7-stream`).
     */
    public const string KIND_STREAM = 'stream';

    /**
     * A response whose whole schema is a `oneOf`/`anyOf` — the incoming
     * direction `a-union-response-selects-its-branch` wires into the same
     * `UnionCatalog`/`BranchSelectors`/`UnionBranchPicker` path a union
     * property already uses. `$models` names every branch; `$unionResolution`
     * carries how the runtime picks one of them, in the same shape
     * {@see UnionCatalog} already carries
     * for a property. A resolution of kind `KIND_PIN` never reaches here —
     * a pin types the response as its single branch directly, `KIND_MODEL`,
     * exactly as a pinned property carries no union at all.
     *
     * The array-of-two-item-shapes case
     * (`activity/list-stargazers-for-repo`) is not a fifth kind: it is a
     * `KIND_SCALAR_LIST` whose `$listItem` is itself a `KIND_UNION` —
     * `ResponseTypeEmitter`/`ResponseDecoder` already recurse into a list
     * item's own spec, so nesting a union there needed no new list kind,
     * only a spec that was not a bare scalar before.
     */
    public const string KIND_UNION = 'union';

    /**
     * @param ScalarFormat|null    $scalarFormat set on a KIND_SCALAR the document gave a `format`
     *                                           paogen binds to a type — the binding a model
     *                                           property with the same `format` already honours
     * @param self|null            $listItem     the item shape, set for KIND_SCALAR_LIST — a bare
     *                                           scalar, or (as of this task) a KIND_UNION
     * @param list<string>|null    $models       every branch's model name, in document order, set for KIND_UNION
     * @param UnionResolution|null $unionResolution how the branch is picked, set for KIND_UNION
     */
    public function __construct(
        public string $kind,
        public ?string $model = null,
        public ?string $scalarPhpType = null,
        public ?self $mapValue = null,
        public ?ScalarFormat $scalarFormat = null,
        public ?self $listItem = null,
        public ?array $models = null,
        public ?UnionResolution $unionResolution = null,
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
     * A scalar the document annotated with a `format` paogen binds — `date`
     * and `date-time` to `\DateTimeImmutable` by default, or to whatever
     * value object the consumer registered for that format. The binding is
     * resolved once, by the same {@see Bindings} a model property consults,
     * so a `format` cannot mean one thing on a property and another in a
     * response list.
     */
    public static function boundScalar(ScalarFormat $format): self
    {
        return new self(self::KIND_SCALAR, scalarPhpType: $format->phpType, scalarFormat: $format);
    }

    /**
     * A list of scalars, decoded from the JSON array and never hydrated —
     * there is no model class to hydrate into, which is the whole point.
     */
    public static function scalarListOf(self $item): self
    {
        return new self(self::KIND_SCALAR_LIST, listItem: $item);
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

    /**
     * A binary body — a PSR-7 stream, handed back exactly as the transport
     * produced it.
     */
    public static function stream(): self
    {
        return new self(self::KIND_STREAM);
    }

    /**
     * @param list<string> $models
     */
    public static function union(array $models, UnionResolution $unionResolution): self
    {
        return new self(self::KIND_UNION, models: $models, unionResolution: $unionResolution);
    }
}
