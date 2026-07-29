<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Bindings;
use Mlavrinenko\Paogen\Generator\ScalarFormat;
use Nette\PhpGenerator\Literal;

/**
 * Builds the smallest expression that turns a parameter variable into a
 * `string` for path / query / header interpolation. Extracted from
 * {@see RequestAssembler} so that class can stay under ADR-004's 250-line
 * limit while still owning request assembly.
 *
 * Detection order:
 *   - `$ref` (or `oneOf` / `anyOf` of `$ref`s) to a scalar-VO component
 *     → `(string) $var->toScalar()` (T-031);
 *   - backed enum (`type: string|integer` + `enum`) → `$var->value`;
 *   - bound scalar format → the matching format-specific call;
 *   - already a `string` schema → bare `$var`;
 *   - everything else → `(string) $var`.
 *
 * @internal
 */
final readonly class ParameterStringExpr
{
    public function __construct(
        private ?ComponentCatalog $components = null,
    ) {}

    public function build(string $varName, Schema|Reference|null $node, Bindings $bindings): Literal
    {
        if ($this->refsScalarVo($node)) {
            return new Literal('(string) $' . $varName . '->toScalar()');
        }

        $schema = $node instanceof Schema ? $node : null;

        if ($schema instanceof Schema && $this->isEnumSchema($schema)) {
            return new Literal('$' . $varName . '->value');
        }

        $formatExpr = $this->formatExpr($schema, $varName, $bindings);

        if ($formatExpr !== null) {
            return new Literal($formatExpr);
        }

        $alreadyString = $schema instanceof Schema && SchemaType::of($schema)->is('string');

        return $alreadyString
            ? new Literal('$' . $varName)
            : new Literal('(string) $' . $varName);
    }

    private function refsScalarVo(Schema|Reference|null $node): bool
    {
        if (!$this->components instanceof ComponentCatalog || $node === null) {
            return false;
        }

        if ($node instanceof Reference) {
            return $this->isScalarComponentRef($node);
        }

        $branches = (\is_array($node->oneOf) && $node->oneOf !== []) ? $node->oneOf
            : ((\is_array($node->anyOf) && $node->anyOf !== []) ? $node->anyOf : []);

        if ($branches === []) {
            return false;
        }
        return array_all(
            $branches,
            fn(Schema|Reference $branch): bool => $branch instanceof Reference && $this->isScalarComponentRef($branch),
        );
    }

    private function isScalarComponentRef(Reference $ref): bool
    {
        \assert($this->components instanceof ComponentCatalog);
        $rawName = ComponentName::rawFromRef($ref->getReference());

        if ($rawName === '') {
            return false;
        }

        $shape = $this->components->shapeOf($rawName);

        return $shape instanceof \Mlavrinenko\Paogen\Generator\Emit\ComponentShape && $shape->kind === ComponentShape::KIND_SCALAR;
    }

    private function formatExpr(?Schema $schema, string $varName, Bindings $bindings): ?string
    {
        if (!$schema instanceof Schema || !\is_string($schema->format)) {
            return null;
        }

        $scalarFormat = $bindings->scalarFormat($schema->format);

        if (!$scalarFormat instanceof ScalarFormat) {
            return null;
        }

        return match ($scalarFormat->kind) {
            ScalarFormat::KIND_DATETIME => '$' . $varName . '->format(\DateTimeInterface::RFC3339)',
            ScalarFormat::KIND_DATE => '$' . $varName . '->format(\'Y-m-d\')',
            ScalarFormat::KIND_SCALAR => '$' . $varName . '->toScalar()',
            default => null,
        };
    }

    private function isEnumSchema(Schema $schema): bool
    {
        if (\is_array($schema->enum) && $schema->enum !== []) {
            $name = SchemaType::of($schema)->name;

            return $name === 'string' || $name === 'integer';
        }

        return false;
    }
}
