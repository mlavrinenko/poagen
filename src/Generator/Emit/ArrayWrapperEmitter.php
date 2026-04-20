<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Bindings;
use Mlavrinenko\Paogen\Generator\Enum\EnumCatalog;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PsrPrinter;

/**
 * Emits a thin wrapper class for a top-level `type: array` component (T-026).
 *
 * GitHub ships a handful of these (`code-frequency-stat`,
 * `api-insights-*-stats`, ...) — schemas that describe an array type but
 * are `$ref`-d as if they were classes. We materialise them as a single-
 * property wrapper so downstream references type-check; runtime round-trip
 * of wire-level arrays is not yet modelled and is tracked separately.
 */
final readonly class ArrayWrapperEmitter
{
    private PsrPrinter $printer;

    public function __construct()
    {
        $this->printer = new PsrPrinter();
    }

    public function emit(
        string $modelNamespace,
        ComponentShape $shape,
        Bindings $bindings,
        NameRegistry $registry,
        EnumCatalog $enums,
    ): string {
        \assert($shape->kind === ComponentShape::KIND_ARRAY);

        $namespaceName = trim($modelNamespace, '\\');
        $file = new PhpFile();
        $file->setStrictTypes();
        $namespace = $file->addNamespace($namespaceName);
        $class = $namespace->addClass($shape->phpName)->setFinal()->setReadOnly();

        $constructor = $class->addMethod('__construct');
        $itemDoc = $this->itemPhpDoc($shape->arrayItems, $bindings, $namespaceName, $registry, $enums);
        $constructor->addComment('@param list<' . $itemDoc . '> $items');

        $constructor->addPromotedParameter('items')
            ->setPublic()
            ->setType('array');

        return $this->printer->printFile($file);
    }

    private function itemPhpDoc(
        ?Schema $items,
        Bindings $bindings,
        string $modelNamespace,
        NameRegistry $registry,
        EnumCatalog $enums,
    ): string {
        if (!$items instanceof Schema) {
            return 'mixed';
        }

        $resolved = TypeResolver::resolve($items, $bindings, $modelNamespace, $registry, $enums);

        return $resolved->phpDoc ?? ($resolved->phpType ?? 'mixed');
    }
}
