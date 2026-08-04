<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\Schema;
use Nette\PhpGenerator\Literal;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpNamespace;
use Poagen\Generator\Generator\Bindings;
use Poagen\Generator\Generator\Enum\EnumCatalog;
use Poagen\Generator\Generator\Naming\NameRegistry;
use Poagen\Runtime\AdditionalPropertyBag;
use Poagen\Runtime\Attribute\AdditionalProperties;

use function in_array;
use function sprintf;

/**
 * Adds the promoted property that carries a model's extra keys, for a schema
 * that declared `properties` *and* allowed more beside them.
 *
 * Such a schema used to be answered with `array<string, mixed>` and a `@todo`,
 * which threw away every declared property; answering it with the declared
 * properties alone would throw away the other half instead. Both halves were
 * declared, so the class carries both: the named properties as typed
 * properties, and the rest in one further property.
 *
 * What that further property is typed as follows the document, in two cases:
 *
 * 1. `additionalProperties: <schema>` — the vendor typed the extra values, so
 *    the property is a typed map (`array<string, Part>`). A map of a declared
 *    shape is a collection, and `declared-shapes-become-types` keeps those as
 *    PHP arrays.
 * 2. `additionalProperties: true` — the vendor allowed extras and declared
 *    nothing about them, so there is no value type to build a typed map from.
 *    The property is an {@see AdditionalPropertyBag} rather than
 *    `array<string, mixed>`: a consumer reaching for an undeclared field gets
 *    an object with a method instead of an array they have to guard.
 *
 * There is no third case. `additionalProperties: false` closes the shape, and
 * an omitted keyword is the document saying nothing — see
 * {@see ObjectShape::declaresOpenExtras}, which is the only place that
 * distinction can be read, because the parser defaults the keyword to `true`.
 *
 * Either way the property is last in the constructor and defaults to empty, so
 * it never moves a required parameter and a caller who has no extras writes
 * nothing.
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
        // Both forms hang off declared properties. A schema with no properties
        // of its own is a map already, and InlineObjectResolver types it as
        // one — there is nothing here to append the extras to.
        if (!ObjectShape::hasProperties($schema)) {
            return;
        }

        if (ObjectShape::hasValueSchema($schema)) {
            $this->applyTypedMap($namespace, $constructor, $schema, $taken, $bindings, $modelNamespace, $registry, $enums);

            return;
        }

        if (ObjectShape::declaresOpenExtras($schema)) {
            $this->applyBag($namespace, $constructor, $taken);
        }
    }

    /**
     * Case 1: the vendor typed the extra values.
     *
     * @param list<string> $taken
     */
    private function applyTypedMap(
        PhpNamespace $namespace,
        Method $constructor,
        Schema $schema,
        array $taken,
        Bindings $bindings,
        string $modelNamespace,
        NameRegistry $registry,
        ?EnumCatalog $enums,
    ): void {
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
     * Case 2: the vendor wrote `additionalProperties: true` and stopped there.
     *
     * No `@param` line: the native type says everything there is to say, and a
     * phpdoc repeating it would be the only place in an emitted model where a
     * doc type adds nothing.
     *
     * The default is `new AdditionalPropertyBag()` rather than `null`, so the
     * property is never nullable and a consumer never guards before asking it
     * a question — which is the whole reason it is an object.
     *
     * @param list<string> $taken
     */
    private function applyBag(PhpNamespace $namespace, Method $constructor, array $taken): void
    {
        $namespace->addUse(AdditionalProperties::class);
        $namespace->addUse(AdditionalPropertyBag::class);

        // Not the bare short name: a model class in this namespace may already
        // answer to `AdditionalPropertyBag`, in which case nette aliases the
        // import and the literal has to name the alias it actually printed.
        $short = $namespace->simplifyName(AdditionalPropertyBag::class);

        $constructor->addPromotedParameter($this->nameFor($taken))
            ->setPublic()
            ->setType(AdditionalPropertyBag::class)
            ->setDefaultValue(new Literal('new ' . $short . '()'))
            ->addAttribute(AdditionalProperties::class);
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
