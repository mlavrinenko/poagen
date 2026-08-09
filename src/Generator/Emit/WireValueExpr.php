<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Nette\PhpGenerator\PhpNamespace;
use Poagen\Generator\Generator\Bindings;
use Poagen\Generator\Generator\ScalarFormat;

use function assert;
use function is_array;
use function is_string;
use function ltrim;
use function sprintf;

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
        $codecCall = $this->codecCall($schema, $bindings, $namespace);

        if ($codecCall !== null) {
            return $required
                ? sprintf('%s(%s)', $codecCall, $var)
                : sprintf('%s === null ? null : %s(%s)', $var, $codecCall, $var);
        }

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

        $schema = $node instanceof Schema ? $node : null;

        return $this->codecCall($schema, $bindings, $namespace) === null
            && $this->formatCall($schema, $bindings, $namespace) === null;
    }

    /**
     * The conversion call for one list item, inside a closure that declares
     * a `string` return — so the enum branch is spelled out rather than left
     * to `Endpoint`.
     *
     * A scalar value object's `toScalar()` cast to `string` only when its
     * declared return type might not already be one — every branch of a
     * scalar-component ref carries its own JSON type (DigitalOcean's
     * `job_names`, `items: {$ref: '.../schema'}}`, target `{type: string}`),
     * and `TagId::toScalar(): string` makes `(string) $v->toScalar()`
     * PHPStan's `cast.useless` under strict rules — a real regression, not
     * a style nit, since `quality-gates-at-maximum-strictness` runs the
     * generated tier at max with no suppression.
     */
    public function itemExpr(string $varName, Schema|Reference|null $node, Bindings $bindings, PhpNamespace $namespace): string
    {
        $var = '$' . $varName;
        $types = $this->scalarBranchTypes($node);

        if ($types !== null) {
            $cast = array_all($types, static fn(string $t): bool => $t === 'string') ? '' : '(string) ';

            return $cast . $var . '->toScalar()';
        }

        $schema = $node instanceof Schema ? $node : null;
        $codecCall = $this->codecCall($schema, $bindings, $namespace);

        if ($codecCall !== null) {
            return sprintf('%s(%s)', $codecCall, $var);
        }

        $format = $this->formatCall($schema, $bindings, $namespace);

        if ($format === null) {
            return '(string) ' . $var;
        }

        $call = $var . '->' . $format;

        return $format === 'toScalar()' ? '(string) ' . $call : $call;
    }

    /**
     * The `format(...)` or `toScalar()` call a bound format needs, or null
     * when the value goes to the wire untouched. Never answers for a codec
     * binding — {@see codecCall()} does, because a codec converts by a
     * static call on the codec class rather than a method call on the
     * value, which needs a different expression shape at every caller.
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

    /**
     * `CodecClass::encode` — a bare callable expression, deliberately with no
     * trailing `(...)` of its own, so every caller appends the argument list
     * that fits its own shape: `Codec::encode($var)` for a required scalar,
     * a ternary wrapping the same call for an optional one, or the call
     * inside a list's `array_map()` closure.
     */
    private function codecCall(?Schema $schema, Bindings $bindings, PhpNamespace $namespace): ?string
    {
        if (!$schema instanceof Schema || !is_string($schema->format)) {
            return null;
        }

        $scalarFormat = $bindings->scalarFormat($schema->format);

        if (!$scalarFormat instanceof ScalarFormat || $scalarFormat->kind !== ScalarFormat::KIND_CODEC) {
            return null;
        }

        $codec = $scalarFormat->codecClass;
        assert($codec !== null);
        $namespace->addUse(ltrim($codec, '\\'));

        return $namespace->simplifyName($codec) . '::encode';
    }

    private function refsScalarVo(Schema|Reference|null $node): bool
    {
        return $this->scalarBranchTypes($node) !== null;
    }

    /**
     * Every branch's declared JSON scalar type, in branch order, when
     * `$node` is a bare `$ref` (or a union of them) to a scalar component.
     * Null when it is not that shape at all — the caller's "not a scalar
     * VO" follows from null the same way it did from `refsScalarVo` false.
     *
     * @return list<'string'|'integer'|'number'|'boolean'>|null
     */
    private function scalarBranchTypes(Schema|Reference|null $node): ?array
    {
        if (!$this->components instanceof ComponentCatalog || $node === null) {
            return null;
        }

        if ($node instanceof Reference) {
            $type = $this->scalarComponentType($node);

            return $type === null ? null : [$type];
        }

        $branches = (is_array($node->oneOf) && $node->oneOf !== []) ? $node->oneOf
            : ((is_array($node->anyOf) && $node->anyOf !== []) ? $node->anyOf : []);

        if ($branches === []) {
            return null;
        }

        $types = [];

        foreach ($branches as $branch) {
            $type = $branch instanceof Reference ? $this->scalarComponentType($branch) : null;

            if ($type === null) {
                return null;
            }

            $types[] = $type;
        }

        return $types;
    }

    /**
     * @return 'string'|'integer'|'number'|'boolean'|null
     */
    private function scalarComponentType(Reference $ref): ?string
    {
        $catalog = $this->components;

        if (!$catalog instanceof ComponentCatalog) {
            return null;
        }

        $rawName = ComponentName::rawFromRef($ref->getReference());

        if ($rawName === '') {
            return null;
        }

        $shape = $catalog->shapeOf($rawName);

        return $shape instanceof ComponentShape && $shape->kind === ComponentShape::KIND_SCALAR ? $shape->scalarType : null;
    }
}
