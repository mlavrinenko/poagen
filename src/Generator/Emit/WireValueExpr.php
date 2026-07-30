<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Bindings;
use Mlavrinenko\Paogen\Generator\ScalarFormat;
use Nette\PhpGenerator\PhpNamespace;

use function is_array;
use function is_string;

/**
 * The expression an emitted operation hands to {@see Endpoint} for one
 * parameter.
 *
 * Deliberately smaller than what the old inline assembly needed. `Endpoint`
 * stringifies scalars and backed enums itself and drops nulls, so most
 * parameters are passed through as they are and the emitted line says the
 * parameter's name and nothing else. What stays is what only the document
 * knows: a date's format, and the fact that a value object stands for a
 * scalar.
 *
 * An optional parameter is reached with `?->` so a null survives to
 * `Endpoint`, which is what drops it. That is why an optional query
 * parameter needs no `if` in the emitted body.
 *
 * @internal
 */
final readonly class WireValueExpr
{
    public function __construct(
        private ?ComponentCatalog $components = null,
    ) {}

    /**
     * @param bool $required whether the emitted parameter can be null
     */
    public function build(
        string $varName,
        Schema|Reference|null $node,
        Bindings $bindings,
        PhpNamespace $namespace,
        bool $required,
    ): string {
        $var = '$' . $varName;
        $arrow = $required ? '->' : '?->';

        if ($this->refsScalarVo($node)) {
            return $var . $arrow . 'toScalar()';
        }

        $schema = $node instanceof Schema ? $node : null;
        $format = $this->formatCall($schema, $bindings, $namespace);

        return $format === null ? $var : $var . $arrow . $format;
    }

    /**
     * Whether the value needs converting at all — a list parameter whose
     * items pass straight through can be handed to `Endpoint` as-is instead
     * of being mapped item by item.
     */
    public function isTransparent(Schema|Reference|null $node, Bindings $bindings, PhpNamespace $namespace): bool
    {
        if ($this->refsScalarVo($node)) {
            return false;
        }

        return $this->formatCall($node instanceof Schema ? $node : null, $bindings, $namespace) === null;
    }

    /**
     * The conversion call for one list item, inside a closure that declares
     * a `string` return — so the enum branch is spelled out rather than left
     * to `Endpoint`.
     */
    public function itemExpr(string $varName, Schema|Reference|null $node, Bindings $bindings, PhpNamespace $namespace): string
    {
        $var = '$' . $varName;

        if ($this->refsScalarVo($node)) {
            return '(string) ' . $var . '->toScalar()';
        }

        $schema = $node instanceof Schema ? $node : null;
        $format = $this->formatCall($schema, $bindings, $namespace);

        if ($format === null) {
            return '(string) ' . $var;
        }

        $call = $var . '->' . $format;

        return $format === 'toScalar()' ? '(string) ' . $call : $call;
    }

    /**
     * The `format(...)` or `toScalar()` call a bound format needs, or null
     * when the value goes to the wire untouched.
     */
    private function formatCall(?Schema $schema, Bindings $bindings, PhpNamespace $namespace): ?string
    {
        if (!$schema instanceof Schema || !is_string($schema->format)) {
            return null;
        }

        $scalarFormat = $bindings->scalarFormat($schema->format);

        if (!$scalarFormat instanceof ScalarFormat) {
            return null;
        }

        if ($scalarFormat->kind === ScalarFormat::KIND_DATETIME) {
            $namespace->addUse('DateTimeInterface');
        }

        return match ($scalarFormat->kind) {
            ScalarFormat::KIND_DATETIME => 'format(' . $namespace->simplifyName('DateTimeInterface') . '::RFC3339)',
            ScalarFormat::KIND_DATE => "format('Y-m-d')",
            ScalarFormat::KIND_SCALAR => 'toScalar()',
            default => null,
        };
    }

    private function refsScalarVo(Schema|Reference|null $node): bool
    {
        if (!$this->components instanceof ComponentCatalog || $node === null) {
            return false;
        }

        if ($node instanceof Reference) {
            return $this->isScalarComponentRef($node);
        }

        $branches = (is_array($node->oneOf) && $node->oneOf !== []) ? $node->oneOf
            : ((is_array($node->anyOf) && $node->anyOf !== []) ? $node->anyOf : []);

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
        $catalog = $this->components;

        if (!$catalog instanceof ComponentCatalog) {
            return false;
        }

        $rawName = ComponentName::rawFromRef($ref->getReference());

        if ($rawName === '') {
            return false;
        }

        $shape = $catalog->shapeOf($rawName);

        return $shape instanceof ComponentShape && $shape->kind === ComponentShape::KIND_SCALAR;
    }
}
