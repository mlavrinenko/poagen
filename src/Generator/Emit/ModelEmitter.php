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
            $synthFqcn = $this->synthesiseChildIfNeeded($className, $phpName, $propSchema, $children, $modelNamespace);

            $resolved = $synthFqcn !== null
                ? new TypeResolver($synthFqcn, null, null, false)
                : TypeResolver::resolve($propSchema, $bindings, $modelNamespace, $registry, $enums);

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
                $this->todoFor($propSchema),
            );
        }

        return new ModelEmission($this->printer->printFile($file), $children);
    }

    /**
     * Detect an inline `type: object` property with declared `properties`
     * and queue it as a synthesised child class (T-013). Returns the child
     * FQCN, or null when the property is not eligible for synthesis.
     *
     * @param list<SynthesisedModel> $children
     */
    private function synthesiseChildIfNeeded(
        string $ownerClassName,
        string $phpPropName,
        Schema|Reference $propSchema,
        array &$children,
        string $modelNamespace,
    ): ?string {
        if (!$propSchema instanceof Schema || $propSchema->type !== 'object') {
            return null;
        }

        if (InlineObjectResolver::classify($propSchema) !== 'synthesise') {
            return null;
        }

        $childName = $ownerClassName . ucfirst($phpPropName);
        $children[] = new SynthesisedModel($childName, $propSchema);

        return '\\' . $modelNamespace . '\\' . $childName;
    }

    /**
     * Build the `@todo` comment for a property whose inline-object schema
     * mixes declared properties with non-trivial `additionalProperties`
     * (T-013 case 3; out of scope). Returns null when no todo applies.
     */
    private function todoFor(Schema|Reference $propSchema): ?string
    {
        if (!$propSchema instanceof Schema || $propSchema->type !== 'object') {
            return null;
        }

        if (InlineObjectResolver::classify($propSchema) !== 'map-todo') {
            return null;
        }

        return '@todo Inline object mixes declared properties with additionalProperties'
            . '; emitted as array<string, mixed>. See T-013 out-of-scope.';
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
