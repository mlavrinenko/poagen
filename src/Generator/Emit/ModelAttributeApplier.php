<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\Discriminator;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Nette\PhpGenerator\Literal;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\PromotedParameter;
use Poagen\Generator\Generator\Bindings;
use Poagen\Generator\Generator\Naming\NameRegistry;
use Poagen\Generator\Generator\ScalarFormat;
use Poagen\Runtime\Attribute\BranchSelector;
use Poagen\Runtime\Attribute\Format;
use Poagen\Runtime\Attribute\WireName;

use function assert;
use function is_string;

/**
 * Attaches `#[WireName]` / `#[Format]` / `#[Discriminator]` to a promoted
 * constructor parameter. Extracted from {@see ModelEmitter} to keep that
 * file under linecop (`quality-gates-at-maximum-strictness`).
 * `attribute-and-phpdoc-driven-serialization` keeps the attribute set
 * small: each attribute encodes one non-structural fact.
 */
final readonly class ModelAttributeApplier
{
    public function apply(
        PhpNamespace $namespace,
        PromotedParameter $param,
        string $wireName,
        string $phpName,
        Schema|Reference $propSchema,
        Bindings $bindings,
        string $modelNamespace,
        NameRegistry $registry,
        string $formatScopeKey = '',
    ): void {
        if ($wireName !== $phpName) {
            $namespace->addUse(WireName::class);
            $param->addAttribute(WireName::class, [$wireName]);
        }

        $this->applyFormat($namespace, $param, $propSchema, $bindings, $formatScopeKey);
        $this->applyUnion($namespace, $param, $propSchema, $bindings, $modelNamespace, $registry);
    }

    /**
     * `#[Format]` is emitted for two kinds, never for `KIND_SCALAR` or
     * `KIND_DATETIME`: `KIND_DATE` because `\DateTimeImmutable` cannot tell
     * `date` from `date-time` on its own and {@see DescriptorParser} needs
     * the format string to pick the right one; `KIND_CODEC` because the
     * property is typed as the codec's foreign target, so
     * {@see PropertyTypeResolver} has no structural way to find the codec at
     * all without it named on the attribute. `KIND_SCALAR` needs neither —
     * the property is already typed as the binding, which
     * `PropertyTypeResolver` recognises by reflection alone.
     *
     * Read off {@see formatBearingSchema()} rather than `$propSchema->format`
     * directly, so a `list<T>`/`array<string,T>` property whose *item*
     * schema carries the format gets the attribute too — the same one
     * `TypeResolver` already used to type every item as the codec's target.
     */
    private function applyFormat(
        PhpNamespace $namespace,
        PromotedParameter $param,
        Schema|Reference $propSchema,
        Bindings $bindings,
        string $formatScopeKey,
    ): void {
        $formatSchema = $this->formatBearingSchema($propSchema);

        if (!$formatSchema instanceof Schema || !is_string($formatSchema->format)) {
            return;
        }

        $scalarFormat = $bindings->scalarFormat($formatSchema->format, $formatScopeKey);

        if (!$scalarFormat instanceof ScalarFormat) {
            return;
        }

        if ($scalarFormat->kind === ScalarFormat::KIND_DATE) {
            $namespace->addUse(Format::class);
            $param->addAttribute(Format::class, [$formatSchema->format]);

            return;
        }

        if ($scalarFormat->kind === ScalarFormat::KIND_CODEC) {
            $codecClass = $scalarFormat->codecClass;
            assert($codecClass !== null);
            $namespace->addUse(Format::class);
            $param->addAttribute(Format::class, [
                'format' => $formatSchema->format,
                'codec' => $this->classLiteral($namespace, $codecClass),
            ]);
        }
    }

    /**
     * The schema that carries `format`, for a property that may itself be
     * scalar, a list of scalars, or a string-keyed map of scalars. One
     * `format` governs the whole property in all three shapes
     * (`codec-bindings-for-foreign-value-types`), so a list/map property's
     * *item* schema answers here exactly as the property's own schema would
     * for a plain scalar one.
     */
    private function formatBearingSchema(Schema|Reference $propSchema): ?Schema
    {
        if (!$propSchema instanceof Schema) {
            return null;
        }

        if (is_string($propSchema->format)) {
            return $propSchema;
        }

        $items = $propSchema->items;

        if ($items instanceof Schema && is_string($items->format)) {
            return $items;
        }

        $additional = $propSchema->additionalProperties;

        return $additional instanceof Schema && is_string($additional->format) ? $additional : null;
    }

    /**
     * How this property's union names a branch, as
     * {@see DiscriminatorEnforcer} resolved it against the whole document. A
     * pin needs no attribute — the branch list was rewritten to one ref, so the
     * property is already typed as that single class.
     */
    private function applyUnion(
        PhpNamespace $namespace,
        PromotedParameter $param,
        Schema|Reference $propSchema,
        Bindings $bindings,
        string $modelNamespace,
        NameRegistry $registry,
    ): void {
        if (!$propSchema instanceof Schema) {
            return;
        }

        $resolution = $bindings->unions->for($propSchema);

        if ($resolution?->kind === UnionResolution::KIND_STRUCTURAL) {
            $this->applySelector($namespace, $param, $resolution, $modelNamespace, $registry);

            return;
        }

        if ($resolution?->kind === UnionResolution::KIND_TAG_ON_PARENT) {
            $this->applyTag($namespace, $param, $resolution, $modelNamespace, $registry, true);

            return;
        }

        if ($resolution?->kind === UnionResolution::KIND_PIN) {
            return;
        }

        $this->applyDeclaredDiscriminator($namespace, $param, $propSchema, $modelNamespace, $registry);
    }

    /**
     * The tag-inside-the-value case, keyed by each branch's own short PHP class
     * name. Unchanged from before the layered resolution existed, so a document
     * that always worked keeps emitting the same bytes.
     */
    private function applyDeclaredDiscriminator(
        PhpNamespace $namespace,
        PromotedParameter $param,
        Schema $propSchema,
        string $modelNamespace,
        NameRegistry $registry,
    ): void {
        $discriminator = $propSchema->discriminator;
        if (!$discriminator instanceof Discriminator) {
            return;
        }

        $shape = CompositionResolver::shapeForUnion($propSchema, $modelNamespace, $registry);
        if ($shape === null) {
            return;
        }

        /** @var list<string> $branches */
        $branches = $shape[1];
        $map = [];

        foreach ($branches as $fqcn) {
            $short = substr((string) strrchr('\\' . $fqcn, '\\'), 1);
            $map[$short] = $this->classLiteral($namespace, $fqcn);
        }

        $namespace->addUse(\Poagen\Runtime\Attribute\Discriminator::class);
        $param->addAttribute(\Poagen\Runtime\Attribute\Discriminator::class, [
            'field' => $discriminator->propertyName,
            'map' => $map,
        ]);
    }

    private function applyTag(
        PhpNamespace $namespace,
        PromotedParameter $param,
        UnionResolution $resolution,
        string $modelNamespace,
        NameRegistry $registry,
        bool $onParent,
    ): void {
        $map = [];

        foreach ($resolution->map as $tag => $branch) {
            $map[$tag] = $this->classLiteral($namespace, ComponentName::fqcnFromRaw($branch, $modelNamespace, $registry));
        }

        $namespace->addUse(\Poagen\Runtime\Attribute\Discriminator::class);
        $param->addAttribute(\Poagen\Runtime\Attribute\Discriminator::class, [
            'field' => (string) $resolution->field,
            'map' => $map,
            'onParent' => $onParent,
        ]);
    }

    private function applySelector(
        PhpNamespace $namespace,
        PromotedParameter $param,
        UnionResolution $resolution,
        string $modelNamespace,
        NameRegistry $registry,
    ): void {
        $selectors = $resolution->selectors;

        if (!$selectors instanceof BranchSelectors) {
            return;
        }

        $fields = [];

        foreach ($selectors->fields as $branch => $field) {
            $fields[$field] = $this->classLiteral($namespace, ComponentName::fqcnFromRaw($branch, $modelNamespace, $registry));
        }

        $arguments = ['fields' => $fields];

        if ($selectors->empty !== null) {
            $arguments['empty'] = $this->classLiteral(
                $namespace,
                ComponentName::fqcnFromRaw($selectors->empty, $modelNamespace, $registry),
            );
        }

        $namespace->addUse(BranchSelector::class);
        $param->addAttribute(BranchSelector::class, $arguments);
    }

    private function classLiteral(PhpNamespace $namespace, string $fqcn): Literal
    {
        $namespace->addUse(ltrim($fqcn, '\\'));

        return new Literal($namespace->simplifyName($fqcn) . '::class');
    }
}
