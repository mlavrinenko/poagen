<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Discriminator;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Bindings;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;
use Mlavrinenko\Paogen\Generator\ScalarFormat;
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
 * file under linecop (ADR-004). ADR-010 keeps the attribute set small:
 * each attribute encodes one non-structural fact.
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

        $this->applyDiscriminator($namespace, $param, $propSchema, $modelNamespace, $registry);
    }

    private function applyDiscriminator(
        PhpNamespace $namespace,
        PromotedParameter $param,
        Schema|Reference $propSchema,
        string $modelNamespace,
        NameRegistry $registry,
    ): void {
        if (!$propSchema instanceof Schema) {
            return;
        }
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
            $namespace->addUse(ltrim($fqcn, '\\'));
            $map[$short] = new Literal($namespace->simplifyName($fqcn) . '::class');
        }

        $namespace->addUse(DiscriminatorAttr::class);
        $param->addAttribute(DiscriminatorAttr::class, [
            'field' => $discriminator->propertyName,
            'map' => $map,
        ]);
    }
}
