<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Bindings;
use Mlavrinenko\Paogen\Generator\Enum\EnumCatalog;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;

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
        Bindings $bindings,
        string $modelNamespace,
        NameRegistry $registry,
        ?EnumCatalog $enums = null,
    ): self {
        if ($node instanceof Reference) {
            $component = ComponentName::rawFromRef($node->getReference());

            if ($enums instanceof EnumCatalog && $enums->isEnumComponent($component)) {
                $fqcn = $enums->componentFqcn($component);
                \assert(\is_string($fqcn));

                return new self($fqcn, null, null, false);
            }

            $fqcn = ComponentName::fqcnFromRef($node->getReference(), $modelNamespace, $registry);

            return new self($fqcn, null, null, false);
        }

        $type = SchemaType::of($node);
        $format = $node->format;
        // `nullable: true` is the 3.0 spelling and `type: [T, "null"]` the 3.1
        // one; a document may use either, so honour both.
        $nullable = (bool) $node->nullable || $type->nullable;

        if (\is_string($format) && $format !== '') {
            $scalarFormat = $bindings->scalarFormat($format);

            if ($scalarFormat instanceof \Mlavrinenko\Paogen\Generator\ScalarFormat) {
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

        return match ($type->name) {
            'string' => new self('string', null, null, $nullable),
            'integer' => new self('int', null, null, $nullable),
            'number' => new self('float', null, null, $nullable),
            'boolean' => new self('bool', null, null, $nullable),
            'array' => self::resolveArray($node, $bindings, $modelNamespace, $registry, $enums, $nullable),
            'object' => InlineObjectResolver::resolve($node, $bindings, $modelNamespace, $registry, $enums),
            // The document said nothing about the type, so neither can the
            // emitted property. `mixed` is declared rather than left off: an
            // untyped promoted property fails analysis at max level, and
            // `mixed` already admits null so it is never marked nullable.
            default => new self('mixed', null, null, false),
        };
    }

    private static function resolveArray(
        Schema $node,
        Bindings $bindings,
        string $modelNamespace,
        NameRegistry $registry,
        ?EnumCatalog $enums,
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
