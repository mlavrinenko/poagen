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

        $type = $node->type;
        $format = $node->format;
        $nullable = (bool) $node->nullable;

        if (\is_string($type) && \is_string($format)) {
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

        return match ($type) {
            'string' => new self('string', null, null, $nullable),
            'integer' => new self('int', null, null, $nullable),
            'number' => new self('float', null, null, $nullable),
            'boolean' => new self('bool', null, null, $nullable),
            'array' => self::resolveArray($node, $bindings, $modelNamespace, $registry, $enums),
            'object' => InlineObjectResolver::resolve($node, $bindings, $modelNamespace, $registry, $enums),
            default => new self(null, 'mixed', null, $nullable),
        };
    }

    private static function resolveArray(
        Schema $node,
        Bindings $bindings,
        string $modelNamespace,
        NameRegistry $registry,
        ?EnumCatalog $enums,
    ): self {
        /** @var Schema|Reference|null $items */
        $items = $node->items;

        if ($items === null) {
            return new self('array', 'list<mixed>', null, (bool) $node->nullable);
        }

        $itemResolved = self::resolve($items, $bindings, $modelNamespace, $registry, $enums);
        $itemType = $itemResolved->phpType ?? 'mixed';
        $docItem = $itemResolved->phpDoc ?? $itemType;

        return new self('array', 'list<' . $docItem . '>', $itemResolved->phpDocUse, (bool) $node->nullable);
    }
}
