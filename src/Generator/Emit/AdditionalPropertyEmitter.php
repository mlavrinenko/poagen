<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Bindings;
use Mlavrinenko\Paogen\Generator\Enum\EnumCatalog;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;
use Mlavrinenko\Paogen\Runtime\Attribute\AdditionalProperties;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpNamespace;

use function in_array;
use function sprintf;

/**
 * Adds the promoted property that carries a model's extra keys, for a schema
 * that declared `properties` *and* a schema for whatever else may arrive.
 *
 * Such a schema used to be answered with `array<string, mixed>` and a `@todo`,
 * which threw away every declared property; answering it with the declared
 * properties alone would throw away the other half instead. Both halves were
 * declared, so the class carries both: the named properties as typed
 * properties, and the rest as one typed map.
 *
 * The map is last in the constructor and defaults to `[]`, so it never moves a
 * required parameter and a caller who has no extras writes nothing.
 *
 * Extracted from {@see ModelEmitter} to keep that file under linecop
 * (ADR-004).
 *
 * @internal
 */
final readonly class AdditionalPropertyEmitter
{
    /** The property name, unless a declared property already answers to it. */
    public const string PHP_NAME = 'additionalProperties';

    /**
     * @param list<string> $taken the PHP names the declared properties already
     *                            claimed on this class
     */
    public function apply(
        PhpNamespace $namespace,
        Method $constructor,
        Schema $schema,
        array $taken,
        Bindings $bindings,
        string $modelNamespace,
        NameRegistry $registry,
        ?EnumCatalog $enums,
    ): void {
        if (!ObjectShape::hasValueSchema($schema) || !ObjectShape::hasProperties($schema)) {
            return;
        }

        $phpName = $this->nameFor($taken);
        $docType = DocTypeSimplifier::shorten(
            $namespace,
            InlineObjectResolver::valueMapDoc($schema, $bindings, $modelNamespace, $registry, $enums),
        );

        $namespace->addUse(AdditionalProperties::class);
        $constructor->addPromotedParameter($phpName)
            ->setPublic()
            ->setType('array')
            ->setDefaultValue([])
            ->addAttribute(AdditionalProperties::class);
        $constructor->addComment(sprintf('@param %s $%s', $docType, $phpName));
    }

    /**
     * A vendor is free to declare a property literally called
     * `additionalProperties`, and it wins — it is the one with a wire name
     * behind it. The extras map steps aside with an underscore rather than
     * colliding, which nette would print as a duplicate parameter.
     *
     * @param list<string> $taken
     */
    private function nameFor(array $taken): string
    {
        $name = self::PHP_NAME;

        while (in_array($name, $taken, true)) {
            $name .= '_';
        }

        return $name;
    }
}
