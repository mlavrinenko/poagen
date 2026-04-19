<?php

/**
 * This file is part of mlavrinenko/paogen
 *
 * @copyright Copyright (c) Maxim Lavrinenko <maxim@lavrinenko.xyz>
 * @license https://opensource.org/license/mit/ MIT License
 */

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Bindings;
use Mlavrinenko\Paogen\Generator\Enum\EnumCatalog;

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
        ?EnumCatalog $enums = null,
    ): self {
        if ($node instanceof Reference) {
            $component = self::componentNameFromRef($node->getReference());

            if ($enums instanceof \Mlavrinenko\Paogen\Generator\Enum\EnumCatalog && $enums->isEnumComponent($component)) {
                $fqcn = $enums->componentFqcn($component);
                \assert(\is_string($fqcn));

                return new self($fqcn, null, null, false);
            }

            $fqcn = '\\' . trim($modelNamespace, '\\') . '\\' . $component;

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

        return match ($type) {
            'string' => new self('string', null, null, $nullable),
            'integer' => new self('int', null, null, $nullable),
            'number' => new self('float', null, null, $nullable),
            'boolean' => new self('bool', null, null, $nullable),
            'array' => self::resolveArray($node, $bindings, $modelNamespace, $enums),
            'object' => new self('array', 'array<string,mixed>', null, $nullable),
            default => new self(null, 'mixed', null, $nullable),
        };
    }

    private static function resolveArray(
        Schema $node,
        Bindings $bindings,
        string $modelNamespace,
        ?EnumCatalog $enums,
    ): self {
        /** @var Schema|Reference|null $items */
        $items = $node->items;

        if ($items === null) {
            return new self('array', 'list<mixed>', null, (bool) $node->nullable);
        }

        $itemResolved = self::resolve($items, $bindings, $modelNamespace, $enums);
        $itemType = $itemResolved->phpType ?? 'mixed';
        $docItem = $itemResolved->phpDoc ?? $itemType;

        return new self('array', 'list<' . $docItem . '>', $itemResolved->phpDocUse, (bool) $node->nullable);
    }

    private static function componentNameFromRef(string $ref): string
    {
        $parts = explode('/', $ref);

        return end($parts);
    }
}
