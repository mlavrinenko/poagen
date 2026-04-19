<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Bindings;
use Mlavrinenko\Paogen\Generator\Enum\EnumCatalog;
use Mlavrinenko\Paogen\Generator\ScalarFormat;
use Nette\PhpGenerator\Literal;

/**
 * Helpers that derive the PROPERTY_MAP runtime shape for one property and
 * the Nette {@see Literal} that renders the shape as a class-constant
 * literal. Extracted from {@see ModelEmitter} to keep that file under the
 * line-count budget.
 *
 * @internal
 */
final class PropertyShape
{
    /**
     * Describe the runtime shape used by the hydrator + serializer for one
     * property: null for scalars, a model FQCN for `$ref` targets,
     * `['list', ?itemFqcn]` for `type: array`, `['scalar', VO::class]`
     * for a format bound to a `ScalarBinding` VO (ADR-007),
     * `['enum', EnumClass::class]` for a `$ref` to a named enum
     * component, or `['union', [A, B, ...], ?discriminator]` for a
     * `oneOf`/`anyOf` of refs (T-008). Anything more exotic is left as
     * null and handled by follow-up tasks.
     *
     * @return null|string|array{0:string,1:?string}|array{0:'union',1:list<string>,2:?string}
     */
    public static function shapeFor(
        Schema|Reference $schema,
        Bindings $bindings,
        string $modelNamespace,
        ?EnumCatalog $enums,
    ): null|string|array {
        if ($schema instanceof Reference) {
            $component = self::componentNameFromRef($schema->getReference());

            if ($enums instanceof EnumCatalog && $enums->isEnumComponent($component)) {
                $fqcn = $enums->componentFqcn($component);
                \assert(\is_string($fqcn));

                return ['enum', $fqcn];
            }

            return self::fqcnFromRef($schema->getReference(), $modelNamespace);
        }

        $union = CompositionResolver::shapeForUnion($schema, $modelNamespace);

        if ($union !== null) {
            return $union;
        }

        if ($schema->type === 'array') {
            $items = $schema->items;
            $item = $items instanceof Reference ? self::fqcnFromRef($items->getReference(), $modelNamespace) : null;

            return ['list', $item];
        }

        $format = \is_string($schema->format) ? $bindings->scalarFormat($schema->format) : null;

        if (!$format instanceof ScalarFormat) {
            return null;
        }

        return match ($format->kind) {
            ScalarFormat::KIND_SCALAR => ['scalar', $format->bindingClass],
            ScalarFormat::KIND_DATETIME => ['datetime', null],
            ScalarFormat::KIND_DATE => ['date', null],
            default => null,
        };
    }

    /**
     * Convert a shape directive into a value that Nette's PhpGenerator will
     * render as a constant literal. Model-refs become `Category::class`;
     * wrapped kinds (`scalar`, `enum`, `list<Foo>`) become
     * `[kind, Foo::class]`; a union becomes
     * `['union', [A::class, B::class], 'propertyName'|null]`.
     *
     * @param null|string|array{0:string,1:?string}|array{0:'union',1:list<string>,2:?string} $shape
     *
     * @return null|Literal|array{0:string,1:null|Literal}|array{0:'union',1:list<Literal>,2:?string}
     */
    public static function shapeLiteral(null|string|array $shape): null|Literal|array
    {
        if ($shape === null) {
            return null;
        }

        if (\is_string($shape)) {
            return new Literal('\\' . ltrim($shape, '\\') . '::class');
        }

        $kind = $shape[0];

        if ($kind === 'union') {
            /** @var list<string> $fqcns */
            $fqcns = $shape[1];
            /** @var ?string $discriminator */
            $discriminator = $shape[2] ?? null;

            return [
                'union',
                array_map(
                    static fn(string $fqcn): Literal => new Literal('\\' . ltrim($fqcn, '\\') . '::class'),
                    $fqcns,
                ),
                $discriminator,
            ];
        }

        /** @var null|string $itemType */
        $itemType = $shape[1];

        return [
            $kind,
            $itemType === null ? null : new Literal('\\' . ltrim($itemType, '\\') . '::class'),
        ];
    }

    private static function componentNameFromRef(string $ref): string
    {
        $parts = explode('/', $ref);

        return end($parts);
    }

    private static function fqcnFromRef(string $ref, string $modelNamespace): string
    {
        return '\\' . trim($modelNamespace, '\\') . '\\' . self::componentNameFromRef($ref);
    }
}
