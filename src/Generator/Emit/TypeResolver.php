<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;

use function assert;
use function is_string;

/**
 * Maps an OpenAPI Schema/Reference to a PHP type plus optional PHPDoc.
 */
final readonly class TypeResolver
{
    public function __construct(
        public ?string $phpType,
        public ?string $phpDoc,
        public ?string $phpDocUse,
        public bool $nullable,
    ) {}

    public static function resolve(
        Schema|Reference $node,
        \Poagen\Generator\Generator\Bindings $bindings,
        string $modelNamespace,
        \Poagen\Generator\Generator\Naming\NameRegistry $registry,
        ?\Poagen\Generator\Generator\Enum\EnumCatalog $enums = null,
    ): self {
        if ($node instanceof Reference) {
            $component = ComponentName::rawFromRef($node->getReference());

            if ($enums instanceof \Poagen\Generator\Generator\Enum\EnumCatalog && $enums->isEnumComponent($component)) {
                $fqcn = $enums->componentFqcn($component);
                assert(is_string($fqcn));

                return new self($fqcn, null, null, false);
            }

            $fqcn = ComponentName::fqcnFromRef($node->getReference(), $modelNamespace, $registry);

            return new self($fqcn, null, null, false);
        }

        $type = SchemaType::of($node);
        $format = $node->format;
        // `nullable: true` is the 3.0 spelling and `type: [T, "null"]` the 3.1
        // one; a document may use either, so honour both.
        $nullable = SchemaType::nullableOf($node);

        if (is_string($format) && $format !== '') {
            $scalarFormat = $bindings->scalarFormat($format);

            if ($scalarFormat instanceof \Poagen\Generator\Generator\ScalarFormat) {
                return new self($scalarFormat->phpType, null, null, $nullable);
            }

            $bound = $bindings->formatType($format);

            if ($bound !== null) {
                return new self('\\' . $bound, null, null, $nullable);
            }
        }

        $union = CompositionResolver::resolveUnion($node, $modelNamespace, $registry);

        if ($union instanceof self) {
            return $union;
        }

        if ($type->isScalarUnion()) {
            // Nullability is already inside the union string, so it is not
            // reported again — `?string|int|null` is not a type.
            return new self($type->unionPhpType(), null, null, false);
        }

        // `type: [integer, string]` and `anyOf: [{type: integer}, {type:
        // string}]` say the same thing two different ways — the branch
        // above already resolves the first spelling, this resolves the
        // second (DigitalOcean's `image_id`, GitHub's equivalent).
        $scalarUnion = CompositionResolver::resolveScalarUnion($node);

        if ($scalarUnion instanceof self) {
            return $scalarUnion;
        }

        // A oneOf/anyOf of a bare scalar and an array of one — GitHub's
        // `fields`/`has` — is a different shape again: resolveScalarUnion
        // above refuses the moment one branch is an array.
        $scalarOrList = CompositionResolver::resolveScalarOrList($node);

        if ($scalarOrList instanceof self) {
            return $scalarOrList;
        }

        return match ($type->name) {
            'string' => new self('string', null, null, $nullable),
            'integer' => new self('int', null, null, $nullable),
            'number' => new self('float', null, null, $nullable),
            'boolean' => new self('bool', null, null, $nullable),
            'array' => self::resolveArray($node, $bindings, $modelNamespace, $registry, $enums, $nullable),
            'object' => InlineObjectResolver::resolve($node, $bindings, $modelNamespace, $registry, $enums),
            // No `type` keyword, which is not the same as no shape: a node
            // declaring `properties` or a value schema for its extra keys
            // described an object and left the redundant keyword off, and
            // `ComponentCatalog` has always read it that way. Answering
            // `mixed` here made one schema a class in the component position
            // and a bag everywhere else.
            default => ObjectShape::is($node)
                ? InlineObjectResolver::resolve($node, $bindings, $modelNamespace, $registry, $enums)
                // The document said nothing about the type, so neither can the
                // emitted property. `mixed` is declared rather than left off: an
                // untyped promoted property fails analysis at max level, and
                // `mixed` already admits null so it is never marked nullable.
                // `UnconstrainedFieldAdvisor` reports every node that lands
                // here, so the silence is visible rather than merely permitted.
                : new self('mixed', null, null, false),
        };
    }

    private static function resolveArray(
        Schema $node,
        \Poagen\Generator\Generator\Bindings $bindings,
        string $modelNamespace,
        \Poagen\Generator\Generator\Naming\NameRegistry $registry,
        ?\Poagen\Generator\Generator\Enum\EnumCatalog $enums,
        bool $nullable,
    ): self {
        /** @var Schema|Reference|null $items */
        $items = $node->items;

        if ($items === null) {
            return new self('array', 'list<mixed>', null, $nullable);
        }

        $itemResolved = self::resolve($items, $bindings, $modelNamespace, $registry, $enums);
        $itemType = $itemResolved->phpType ?? 'mixed';
        $docItem = $itemResolved->phpDoc ?? $itemType;

        return new self('array', 'list<' . $docItem . '>', $itemResolved->phpDocUse, $nullable);
    }
}
