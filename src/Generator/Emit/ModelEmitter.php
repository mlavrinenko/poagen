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
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\PsrPrinter;

/**
 * Emits a single `final readonly` PHP class for one OpenAPI named schema.
 *
 * No I/O — given (name, schema, bindings) returns the printed PHP source.
 */
final readonly class ModelEmitter
{
    private PsrPrinter $printer;

    public function __construct()
    {
        $this->printer = new PsrPrinter();
    }

    public function emit(string $modelNamespace, string $className, Schema $schema, Bindings $bindings): string
    {
        $modelNamespace = trim($modelNamespace, '\\');

        $file = new PhpFile();
        $file->setStrictTypes();

        $namespace = $file->addNamespace($modelNamespace);
        $class = $namespace->addClass($className)->setFinal()->setReadOnly();

        $constructor = $class->addMethod('__construct');

        /** @var array<string,Schema|Reference> $properties */
        $properties = $schema->properties;
        /** @var list<string> $required */
        $required = $schema->required ?? [];

        $names = array_keys($properties);
        sort($names, \SORT_STRING);

        // Required first (in sorted order), then optional. PHP forbids
        // required-after-optional.
        $ordered = array_merge(
            array_values(array_filter($names, static fn(string $n): bool => \in_array($n, $required, true))),
            array_values(array_filter($names, static fn(string $n): bool => !\in_array($n, $required, true))),
        );

        foreach ($ordered as $propName) {
            $propSchema = $properties[$propName];
            $isRequired = \in_array($propName, $required, true);

            $this->addProperty(
                $namespace,
                $constructor,
                $propName,
                $propSchema,
                $isRequired,
                $bindings,
                $modelNamespace,
            );
        }

        return $this->printer->printFile($file);
    }

    private function addProperty(
        PhpNamespace $namespace,
        \Nette\PhpGenerator\Method $constructor,
        string $name,
        Schema|Reference $propSchema,
        bool $isRequired,
        Bindings $bindings,
        string $modelNamespace,
    ): void {
        $resolved = TypeResolver::resolve($propSchema, $bindings, $modelNamespace);
        $type = $resolved->phpType;
        $isNullable = !$isRequired || $resolved->nullable;

        $param = $constructor->addPromotedParameter($this->phpName($name))->setPublic();

        $useType = $type;

        if ($useType !== null) {
            $param->setType($useType);
        }

        if ($isNullable) {
            $param->setNullable();
            $param->setDefaultValue(null);
        }

        if ($resolved->phpDoc !== null) {
            $constructor->addComment(\sprintf(
                '@param %s%s $%s',
                $isNullable ? '?' : '',
                $resolved->phpDoc,
                $this->phpName($name),
            ));
        }

        // Hint use-statements for fully qualified names so the printed file uses short forms.
        if ($useType !== null && str_contains($useType, '\\')) {
            $namespace->addUse(ltrim($useType, '\\'));
        }

        if ($resolved->phpDocUse !== null) {
            $namespace->addUse(ltrim($resolved->phpDocUse, '\\'));
        }
    }

    private function phpName(string $openApiName): string
    {
        if (preg_match('/^[a-zA-Z_]\w*$/', $openApiName) === 1) {
            return $openApiName;
        }

        // Snake_case kebab-case → camelCase fallback.
        $parts = preg_split('/[^a-zA-Z0-9]+/', $openApiName);

        if ($parts === false || $parts === []) {
            return 'value';
        }

        $head = strtolower($parts[0]);
        $tail = array_map(static fn(string $p): string => ucfirst(strtolower($p)), \array_slice($parts, 1));

        return $head . implode('', $tail);
    }
}
