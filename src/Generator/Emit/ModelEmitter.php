<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Bindings;
use Mlavrinenko\Paogen\Generator\Enum\EnumCatalog;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\PsrPrinter;

/**
 * Emits a single `final readonly` PHP class for one OpenAPI named schema.
 *
 * No I/O — given (name, schema, bindings) returns the printed PHP source
 * wrapped in a {@see ModelEmission} that also lists any synthesised
 * nested-object classes the caller must emit next (T-013).
 */
final readonly class ModelEmitter
{
    private PsrPrinter $printer;

    public function __construct()
    {
        $this->printer = new PsrPrinter();
    }

    public function emit(
        string $modelNamespace,
        string $className,
        Schema $schema,
        Bindings $bindings,
        ?EnumCatalog $enums = null,
    ): ModelEmission {
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

        /** @var list<array{wire: string, php: string, shape: null|string|array{0:string,1:?string}, nullable: bool}> $propertyMap */
        $propertyMap = [];
        /** @var list<SynthesisedModel> $children */
        $children = [];

        foreach ($ordered as $propName) {
            $propSchema = $properties[$propName];
            $isRequired = \in_array($propName, $required, true);
            $phpName = $this->phpName($propName);
            $synthFqcn = $this->synthesiseChildIfNeeded($className, $phpName, $propSchema, $children, $modelNamespace);

            if ($synthFqcn !== null) {
                $resolved = new TypeResolver($synthFqcn, null, null, false);
                $shape = ltrim($synthFqcn, '\\');
            } else {
                $resolved = TypeResolver::resolve($propSchema, $bindings, $modelNamespace, $enums);
                $shape = PropertyShape::shapeFor($propSchema, $bindings, $modelNamespace, $enums);
            }

            $isNullable = !$isRequired || $resolved->nullable;

            $this->addProperty(
                $namespace,
                $constructor,
                $phpName,
                $resolved,
                $isNullable,
                $this->todoFor($propSchema),
            );

            $propertyMap[] = [
                'wire' => $propName,
                'php' => $phpName,
                'shape' => $shape,
                'nullable' => $isNullable,
            ];
        }

        $this->emitPropertyMap($class, $propertyMap);
        $this->emitJsonSerialize($class, $propertyMap);

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
        \Nette\PhpGenerator\Method $constructor,
        string $phpName,
        TypeResolver $resolved,
        bool $isNullable,
        ?string $todo = null,
    ): void {
        $type = $resolved->phpType;
        $param = $constructor->addPromotedParameter($phpName)->setPublic();

        if ($type !== null) {
            $param->setType($type);
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

        if ($todo !== null) {
            $constructor->addComment($todo);
        }

        // Hint use-statements for FQNs so the printed file uses short forms.
        if ($type !== null && str_contains($type, '\\')) {
            $namespace->addUse(ltrim($type, '\\'));
        }

        if ($resolved->phpDocUse !== null) {
            $namespace->addUse(ltrim($resolved->phpDocUse, '\\'));
        }
    }

    /**
     * Emit the `PROPERTY_MAP` class constant that pairs each PHP property
     * name with (a) its original schema key and (b) its runtime shape.
     *
     * @param list<array{wire: string, php: string, shape: null|string|array{0:string,1:?string}, nullable: bool}> $propertyMap
     */
    private function emitPropertyMap(ClassType $class, array $propertyMap): void
    {
        $value = [];

        foreach ($propertyMap as $entry) {
            $value[$entry['php']] = [$entry['wire'], PropertyShape::shapeLiteral($entry['shape'])];
        }

        $const = $class->addConstant('PROPERTY_MAP', $value)->setPublic()->setType('array');
        $const->addComment('Paogen marshal/unmarshal contract. See ADR-007.');
        $const->addComment('');
        $const->addComment('phpName => [wireKey, shape]');
        $const->addComment(
            'shape is one of: null (scalar pass-through), `\\FQCN::class` (model ref),'
            . ' [\'list\', null] (list<scalar>), [\'list\', \\FQCN::class] (list<Model>),'
            . ' [\'scalar\', \\FQCN::class] (ScalarBinding VO),'
            . ' [\'datetime\', null] (format: date-time → \\DateTimeImmutable),'
            . ' [\'date\', null] (format: date → \\DateTimeImmutable),'
            . ' [\'enum\', \\FQCN::class] (named enum component → backed enum).',
        );
        $const->addComment('');
        $const->addComment('@var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}}>');
    }

    /**
     * Emit `jsonSerialize()` that renames PHP property names back to their
     * original schema keys. ScalarBinding VOs route through `toScalar()`;
     * built-in datetime/date shapes route through `format()`; everything
     * else passes through unchanged.
     *
     * @param list<array{wire: string, php: string, shape: null|string|array{0:string,1:?string}, nullable: bool}> $propertyMap
     */
    private function emitJsonSerialize(ClassType $class, array $propertyMap): void
    {
        $method = $class->addMethod('jsonSerialize')->setPublic()->setReturnType('array');
        $method->addComment('@return array<string, mixed>');
        $method->addBody('return [');

        foreach ($propertyMap as $entry) {
            $method->addBody(\sprintf(
                '    %s => %s,',
                var_export($entry['wire'], true),
                $this->serializeExpr($entry),
            ));
        }

        $method->addBody('];');
    }

    /**
     * @param array{wire: string, php: string, shape: null|string|array{0:string,1:?string}, nullable: bool} $entry
     */
    private function serializeExpr(array $entry): string
    {
        $base = '$this->' . $entry['php'];
        $shape = $entry['shape'];

        if (!\is_array($shape)) {
            return $base;
        }

        $op = $entry['nullable'] ? '?->' : '->';

        return match ($shape[0]) {
            'scalar' => $base . $op . 'toScalar()',
            'datetime' => $base . $op . 'format(\\DateTimeInterface::RFC3339)',
            'date' => $base . $op . "format('Y-m-d')",
            default => $base,
        };
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
