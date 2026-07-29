<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Bindings;
use Mlavrinenko\Paogen\Generator\Enum\EnumCatalog;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\PsrPrinter;

/**
 * Emits a single `final readonly` PHP class for one OpenAPI named schema.
 *
 * Per ADR-010, generated Models are lean DTOs. Wire metadata moves out:
 *   - phpdoc carries structural type information (`@param list<Tag>`);
 *   - `#[WireName] / #[Format] / #[Discriminator]` carry non-structural
 *     facts. The runtime `Marshaller` / `Hydrator` read both.
 *
 * No I/O — given (name, schema, bindings) returns the printed PHP source
 * wrapped in a {@see ModelEmission} that also lists any synthesised
 * nested-object classes the caller must emit next.
 */
final readonly class ModelEmitter
{
    private PsrPrinter $printer;

    public function __construct(
        private ModelAttributeApplier $attributes = new ModelAttributeApplier(),
        private PropertySynthesiser $properties = new PropertySynthesiser(),
    ) {
        $this->printer = new PsrPrinter();
    }

    /**
     * @param list<string> $implements short PHP interface names, defined in $modelNamespace (T-026)
     */
    public function emit(
        string $modelNamespace,
        string $className,
        Schema $schema,
        Bindings $bindings,
        ?EnumCatalog $enums = null,
        ?NameRegistry $registry = null,
        array $implements = [],
    ): ModelEmission {
        \assert($registry instanceof NameRegistry, 'NameRegistry is required (T-023).');
        $modelNamespace = trim($modelNamespace, '\\');
        $file = new PhpFile();
        $file->setStrictTypes();
        $namespace = $file->addNamespace($modelNamespace);
        $class = $namespace->addClass($className)->setFinal()->setReadOnly();

        foreach ($implements as $iface) {
            $class->addImplement($modelNamespace . '\\' . $iface);
        }

        $constructor = $class->addMethod('__construct');

        /** @var array<string,Schema|Reference> $properties */
        $properties = $schema->properties;
        /** @var list<string> $required */
        $required = $schema->required ?? [];

        // YAML parses a purely numeric key (e.g. `-1:`) as an int; coerce
        // every key to a string so the downstream name normalisers have
        // a uniform input shape.
        $names = [];
        foreach (array_keys($properties) as $k) {
            $names[] = \is_int($k) ? (string) $k : $k;
        }
        sort($names, \SORT_STRING);

        // Required first (in sorted order), then optional. PHP forbids
        // required-after-optional.
        $ordered = array_merge(
            array_values(array_filter($names, static fn(string $n): bool => \in_array($n, $required, true))),
            array_values(array_filter($names, static fn(string $n): bool => !\in_array($n, $required, true))),
        );

        /** @var list<SynthesisedModel> $children */
        $children = [];

        foreach ($ordered as $propName) {
            $propSchema = $properties[$propName];
            $isRequired = \in_array($propName, $required, true);
            $phpName = $this->phpName($propName);

            $resolved = $this->properties->resolve(
                $className,
                $phpName,
                $propSchema,
                $children,
                $modelNamespace,
                $bindings,
                $registry,
                $enums,
            );

            $isNullable = !$isRequired || $resolved->nullable;

            $this->addProperty(
                $namespace,
                $constructor,
                $propName,
                $phpName,
                $resolved,
                $isNullable,
                $propSchema,
                $bindings,
                $modelNamespace,
                $registry,
                $this->properties->todoFor($propSchema),
            );
        }

        return new ModelEmission($this->printer->printFile($file), $children);
    }

    private function addProperty(
        PhpNamespace $namespace,
        Method $constructor,
        string $wireName,
        string $phpName,
        TypeResolver $resolved,
        bool $isNullable,
        Schema|Reference $propSchema,
        Bindings $bindings,
        string $modelNamespace,
        NameRegistry $registry,
        ?string $todo = null,
    ): void {
        $type = $resolved->phpType;
        $param = $constructor->addPromotedParameter($phpName)->setPublic();

        if ($type !== null) {
            $param->setType($type);
        }
        if ($isNullable) {
            $param->setNullable()->setDefaultValue(null);
        }
        if ($resolved->phpDoc !== null) {
            $constructor->addComment(\sprintf('@param %s%s $%s', $isNullable ? '?' : '', $resolved->phpDoc, $phpName));
        }
        if ($todo !== null) {
            $constructor->addComment($todo);
        }

        // Hint use-statements for FQNs so the printed file uses short forms.
        foreach ($type !== null ? explode('|', $type) : [] as $part) {
            if (str_contains($part, '\\')) {
                $namespace->addUse(ltrim($part, '\\'));
            }
        }
        if ($resolved->phpDocUse !== null) {
            $namespace->addUse(ltrim($resolved->phpDocUse, '\\'));
        }

        $this->attributes->apply($namespace, $param, $wireName, $phpName, $propSchema, $bindings, $modelNamespace, $registry);
    }

    private function phpName(string $openApiName): string
    {
        if (preg_match('/^[a-zA-Z_]\w*$/', $openApiName) === 1) {
            return $openApiName;
        }
        $parts = preg_split('/[^a-zA-Z0-9]+/', $openApiName);
        if ($parts === false || $parts === []) {
            return 'value';
        }
        $head = strtolower($parts[0]);
        $tail = array_map(static fn(string $p): string => ucfirst(strtolower($p)), \array_slice($parts, 1));
        $name = $head . implode('', $tail);

        // `'1'`, `'-'`, etc. still yield an invalid PHP identifier — prefix `_`.
        return ($name === '' || preg_match('/^\d/', $name) === 1) ? '_' . $name : $name;
    }
}
