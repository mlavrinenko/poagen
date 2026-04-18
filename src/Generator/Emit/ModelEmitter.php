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
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Literal;
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
        $namespace->addUse(\JsonSerializable::class);
        $class = $namespace->addClass($className)->setFinal()->setReadOnly();
        $class->addImplement(\JsonSerializable::class);

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

        /** @var list<array{wire: string, php: string, shape: null|string|array{0:string,1:?string}}> $propertyMap */
        $propertyMap = [];

        foreach ($ordered as $propName) {
            $propSchema = $properties[$propName];
            $isRequired = \in_array($propName, $required, true);

            $phpName = $this->phpName($propName);
            $shape = $this->shapeFor($propSchema, $modelNamespace);

            $this->addProperty(
                $namespace,
                $constructor,
                $phpName,
                $propSchema,
                $isRequired,
                $bindings,
                $modelNamespace,
            );

            $propertyMap[] = ['wire' => $propName, 'php' => $phpName, 'shape' => $shape];
        }

        $this->emitPropertyMap($class, $propertyMap);
        $this->emitJsonSerialize($class, $propertyMap);

        return $this->printer->printFile($file);
    }

    private function addProperty(
        PhpNamespace $namespace,
        \Nette\PhpGenerator\Method $constructor,
        string $phpName,
        Schema|Reference $propSchema,
        bool $isRequired,
        Bindings $bindings,
        string $modelNamespace,
    ): void {
        $resolved = TypeResolver::resolve($propSchema, $bindings, $modelNamespace);
        $type = $resolved->phpType;
        $isNullable = !$isRequired || $resolved->nullable;

        $param = $constructor->addPromotedParameter($phpName)->setPublic();

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
                $phpName,
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

    /**
     * Emit the `PROPERTY_MAP` class constant that pairs each PHP property
     * name with (a) its original schema key and (b) its runtime shape.
     *
     * @param list<array{wire: string, php: string, shape: null|string|array{0:string,1:?string}}> $propertyMap
     */
    private function emitPropertyMap(ClassType $class, array $propertyMap): void
    {
        $value = [];

        foreach ($propertyMap as $entry) {
            $value[$entry['php']] = [$entry['wire'], $this->shapeLiteral($entry['shape'])];
        }

        $const = $class->addConstant('PROPERTY_MAP', $value)->setPublic()->setType('array');
        $const->addComment('Paogen marshal/unmarshal contract. See ADR-007.');
        $const->addComment('');
        $const->addComment('phpName => [wireKey, shape]');
        $const->addComment(
            'shape is one of: null (scalar pass-through), `\\FQCN::class` (model ref),'
            . ' [\'list\', null] (list<scalar>), [\'list\', \\FQCN::class] (list<Model>).',
        );
        $const->addComment('');
        $const->addComment('@var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}}>');
    }

    /**
     * Convert a shape directive into a value that Nette's PhpGenerator will
     * render as a constant literal. Model-refs are printed as
     * `Category::class`; the `Literal` wrapper is what unlocks that.
     *
     * @param null|string|array{0:string,1:?string} $shape
     *
     * @return null|Literal|array{0:string,1:null|Literal}
     */
    private function shapeLiteral(null|string|array $shape): null|Literal|array
    {
        if ($shape === null) {
            return null;
        }

        if (\is_string($shape)) {
            return new Literal('\\' . ltrim($shape, '\\') . '::class');
        }

        [$kind, $itemType] = $shape;

        return [
            $kind,
            $itemType === null ? null : new Literal('\\' . ltrim($itemType, '\\') . '::class'),
        ];
    }

    /**
     * Emit `jsonSerialize()` that renames PHP property names back to their
     * original schema keys for on-the-wire transmission.
     *
     * @param list<array{wire: string, php: string, shape: null|string|array{0:string,1:?string}}> $propertyMap
     */
    private function emitJsonSerialize(ClassType $class, array $propertyMap): void
    {
        $method = $class->addMethod('jsonSerialize')
            ->setPublic()
            ->setReturnType('array');

        $method->addComment('@return array<string, mixed>');

        $method->addBody('return [');

        foreach ($propertyMap as $entry) {
            $method->addBody(\sprintf(
                '    %s => $this->%s,',
                var_export($entry['wire'], true),
                $entry['php'],
            ));
        }

        $method->addBody('];');
    }

    /**
     * Describe the runtime shape used by the hydrator + serializer for one
     * property: null for scalars, a model FQCN for `$ref` targets, or
     * `['list', ?itemFqcn]` for `type: array`. Anything more exotic (inline
     * nested objects, oneOf/anyOf, maps via `additionalProperties`) is left
     * as null and handled by follow-up tasks 008 / 013.
     *
     * @return null|string|array{0:string,1:?string}
     */
    private function shapeFor(Schema|Reference $schema, string $modelNamespace): null|string|array
    {
        if ($schema instanceof Reference) {
            return $this->fqcnFromRef($schema->getReference(), $modelNamespace);
        }

        if ($schema->type === 'array') {
            /** @var Schema|Reference|null $items */
            $items = $schema->items;

            if ($items instanceof Reference) {
                return ['list', $this->fqcnFromRef($items->getReference(), $modelNamespace)];
            }

            return ['list', null];
        }

        return null;
    }

    private function fqcnFromRef(string $ref, string $modelNamespace): string
    {
        $parts = explode('/', $ref);
        $component = end($parts);

        return '\\' . trim($modelNamespace, '\\') . '\\' . $component;
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
