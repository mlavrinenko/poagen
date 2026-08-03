<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Discriminator;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Bindings;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;
use Mlavrinenko\Paogen\Generator\ScalarFormat;
use Mlavrinenko\Paogen\Runtime\Attribute\BranchSelector as BranchSelectorAttr;
use Mlavrinenko\Paogen\Runtime\Attribute\Discriminator as DiscriminatorAttr;
use Mlavrinenko\Paogen\Runtime\Attribute\Format;
use Mlavrinenko\Paogen\Runtime\Attribute\WireName;
use Nette\PhpGenerator\Literal;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\PromotedParameter;

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
    ): void {
        if ($wireName !== $phpName) {
            $namespace->addUse(WireName::class);
            $param->addAttribute(WireName::class, [$wireName]);
        }

        if ($propSchema instanceof Schema && is_string($propSchema->format)) {
            $scalarFormat = $bindings->scalarFormat($propSchema->format);

            if ($scalarFormat instanceof ScalarFormat && $scalarFormat->kind === ScalarFormat::KIND_DATE) {
                $namespace->addUse(Format::class);
                $param->addAttribute(Format::class, [$propSchema->format]);
            }
        }

        $this->applyUnion($namespace, $param, $propSchema, $bindings, $modelNamespace, $registry);
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

        $namespace->addUse(DiscriminatorAttr::class);
        $param->addAttribute(DiscriminatorAttr::class, [
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

        $namespace->addUse(DiscriminatorAttr::class);
        $param->addAttribute(DiscriminatorAttr::class, [
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

        $namespace->addUse(BranchSelectorAttr::class);
        $param->addAttribute(BranchSelectorAttr::class, $arguments);
    }

    private function classLiteral(PhpNamespace $namespace, string $fqcn): Literal
    {
        $namespace->addUse(ltrim($fqcn, '\\'));

        return new Literal($namespace->simplifyName($fqcn) . '::class');
    }
}
