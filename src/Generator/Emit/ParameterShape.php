<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\json\JsonPointer;
use cebe\openapi\spec\Parameter;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;

use function is_array;
use function sprintf;

/**
 * Whether one parameter's schema is a shape paogen emits, and — when it is
 * not — the refusal that says so.
 *
 * Two of the three positions had a gate and the third did not. `query` and
 * `header` each read their own supported subset off `SchemaType`, and a
 * parameter outside it stopped the run; `path` accepted whatever the document
 * declared and handed it to {@see TypeResolver}, so an inline object, an
 * array, or a node with no `type` at all fell through to that resolver's
 * `mixed` default and only surfaced two layers later as a PHPStan error
 * against `Endpoint::path()` — inside generated code, which a consumer reads
 * as their own bug. `fail-loud-never-silent` makes that a default-deny
 * question rather than a matter of taste, and the same discipline has to
 * apply uniformly: two constructs the generator cannot represent must fail
 * the same way.
 *
 * So all three positions ask their question here. Each keeps its own subset —
 * they are genuinely different, and widening one to match another is a
 * separate decision, not a refactoring — but the reading, the refusal
 * sentence and the schema pointer are shared, so a third near-identical gate
 * did not have to be written to add the third position.
 *
 * The subsets, and why each is what it is:
 *
 *   - `path` — a scalar, several scalars in either spelling, or a `$ref` (or
 *     a union of them) naming a component. A path parameter is interpolated
 *     into the URI, and `Endpoint::path()` takes
 *     `string|int|float|bool|BackedEnum|Stringable`; nothing wider fits, and
 *     the scalar union `scalar-union-path-parameters-resolve-not-refuse`
 *     landed does fit, so it stays resolved rather than refused.
 *   - `query` — a scalar, or an array whose items are scalars, because
 *     `Endpoint::query()` also serialises a repeated key.
 *   - `header` — an optional scalar. A required header parameter is refused
 *     whatever its schema: the emitted signature gives every header a
 *     nullable default.
 *
 * Nothing here reads a `type` keyword itself — {@see SchemaType} is the one
 * reader of that in `src/`, and {@see CompositionResolver::resolveScalarUnion()}
 * the one reader of the `anyOf`/`oneOf` spelling of a scalar union. This class
 * asks those two the question and combines the answers.
 *
 * @internal
 */
final readonly class ParameterShape
{
    /**
     * True when paogen can emit this parameter. False is a refusal, and
     * {@see describe()} says which one.
     */
    public static function supports(Parameter $param): bool
    {
        return match ($param->in) {
            'path' => self::supportsPath($param),
            'query' => self::supportsQuery($param),
            'header' => self::supportsHeader($param),
            default => false,
        };
    }

    /**
     * The refusal for a parameter {@see supports()} rejected: the parameter,
     * its position, how the document spelled its type, where in the document
     * it sits, and what would make it acceptable there. Only meaningful to
     * call after {@see supports()} has returned false.
     */
    public static function describe(Parameter $param): string
    {
        $schema = $param->schema;

        return sprintf(
            "parameter '%s' (in: %s, type: %s)%s is outside paogen's supported parameter shapes — %s",
            $param->name,
            $param->in,
            $schema instanceof Schema ? SchemaType::of($schema)->describe() : 'unspecified',
            self::locationOf($param),
            self::remedyFor($param->in),
        );
    }

    /**
     * True when a supported query parameter is the array-of-scalars form
     * rather than the plain scalar one — the caller emits a repeated key for
     * it. Meaningless for a parameter {@see supports()} rejected.
     */
    public static function isArrayQuery(Parameter $param): bool
    {
        $schema = $param->schema;

        return $schema instanceof Schema && SchemaType::of($schema)->is('array');
    }

    private static function supportsPath(Parameter $param): bool
    {
        $schema = $param->schema;

        // A `$ref` names a component, and the component is gated where it is
        // declared — `ComponentCatalog` and `DiscriminatorEnforcer` both run
        // over it — so the reference resolves to a named type rather than to
        // the `mixed` this gate exists to stop. What it resolves to is not
        // read here: `OperationAnalyzer` does not follow schema references,
        // and a `$ref` to a component that is not scalar is a narrower,
        // separate finding.
        if ($schema instanceof Reference) {
            return true;
        }

        if (!$schema instanceof Schema) {
            return false;
        }
        if (self::isScalarShape($schema)) {
            return true;
        }
        return self::isRefUnion($schema);
    }

    private static function supportsQuery(Parameter $param): bool
    {
        $schema = $param->schema;

        if (!$schema instanceof Schema) {
            return false;
        }

        $type = SchemaType::of($schema);

        if ($type->isScalar()) {
            return true;
        }

        if (!$type->is('array')) {
            return false;
        }

        $items = $schema->items;

        return $items instanceof Schema && SchemaType::of($items)->isScalar();
    }

    private static function supportsHeader(Parameter $param): bool
    {
        if ($param->required) {
            return false;
        }

        $schema = $param->schema;

        return $schema instanceof Schema && SchemaType::of($schema)->isScalar();
    }

    /**
     * True when the schema names one scalar, or several scalars in whichever
     * of the two spellings the document used — `type: [integer, string]` and
     * `anyOf: [{type: integer}, {type: string}]` say the same thing, and both
     * resolve to the same PHP union.
     */
    private static function isScalarShape(Schema $schema): bool
    {
        $type = SchemaType::of($schema);
        if ($type->isScalar()) {
            return true;
        }
        if ($type->isScalarUnion()) {
            return true;
        }
        return CompositionResolver::resolveScalarUnion($schema) instanceof TypeResolver;
    }

    /**
     * True when every composition branch is a `$ref`, the shape
     * {@see CompositionResolver::resolveUnion()} turns into a PHP union of
     * the named types — DigitalOcean's `ssh_key_identifier`, an
     * `anyOf: [ssh_key_id, ssh_key_fingerprint]` over two scalar components,
     * which emits as a union of the two scalar value objects T-031 gives
     * them. Like a bare `$ref`, what each branch names is not read here.
     *
     * `allOf` is refused rather than followed: `TypeResolver` does not
     * flatten one in a parameter position — only `ModelPlanner` does, for a
     * component — so a path parameter spelled that way reaches the `mixed`
     * default whatever its branches say.
     */
    private static function isRefUnion(Schema $schema): bool
    {
        if (is_array($schema->allOf) && $schema->allOf !== []) {
            return false;
        }

        $branches = SchemaWalk::compositionBranches($schema);

        return $branches !== []
            && array_all($branches, static fn(Schema|Reference $branch): bool => $branch instanceof Reference);
    }

    /**
     * Where the parameter sits in the document, in the form the response and
     * request-body refusals already use. Empty when the document position was
     * never populated — a caller that built the `Operation` by hand rather
     * than reading a file.
     */
    private static function locationOf(Parameter $param): string
    {
        $pointer = $param->getDocumentPosition();

        return $pointer instanceof JsonPointer ? ' at ' . $pointer->getPointer() : '';
    }

    /**
     * What would make a parameter acceptable in this position. Per position,
     * not one blanket list: the sentence a consumer needs is the one about
     * the position they wrote, and naming all three made the reader work out
     * which clause applied to them.
     */
    private static function remedyFor(string $in): string
    {
        return match ($in) {
            'path' => 'a path parameter is interpolated into the URI, so its schema must name a scalar '
                . '(string, integer, number or boolean), a union of scalars, or one or more $refs to component schemas',
            'query' => "a query parameter's schema must name a scalar, or an array whose items are scalars",
            'header' => 'a header parameter must be optional (paogen gives every header a nullable default) '
                . 'and its schema must name a scalar',
            default => 'paogen emits path, query and header parameters — no other `in` value',
        };
    }
}
