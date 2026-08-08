<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PsrPrinter;
use Poagen\Generator\Generator\Bindings;
use Poagen\Generator\Generator\Enum\EnumCatalog;
use Poagen\Generator\Generator\ModelPlanner;
use Poagen\Generator\Generator\Naming\NameRegistry;
use Poagen\Generator\Generator\PropertyRenameValidator;

use function array_slice;
use function assert;
use function in_array;
use function is_int;

use const SORT_STRING;

/**
 * Emits a single `final readonly` PHP class for one OpenAPI named schema.
 *
 * Per `attribute-and-phpdoc-driven-serialization`, generated Models are lean
 * DTOs. Wire metadata moves out:
 *   - phpdoc carries structural type information (`@param list<Tag>`);
 *   - `#[WireName] / #[Format] / #[Discriminator]` carry non-structural
 *     facts. The runtime `Marshaller` / `Hydrator` read both.
 *
 * No I/O — given (name, schema, bindings) returns the printed PHP source
 * wrapped in a {@see ModelEmission} that also lists any synthesised
 * nested-object classes the caller must emit next.
 *
 * Also the one place `Profile::$propertyFormats` can be checked against a
 * model it names, since that field keys on the emitted class name rather
 * than a document component name — {@see PropertyFormatKeys} does the
 * checking, this class supplies $className and every wire property name it
 * declares (bind-a-format-per-property).
 */
final readonly class ModelEmitter
{
    private PsrPrinter $printer;

    public function __construct(
        private PropertySynthesiser $properties = new PropertySynthesiser(),
        private AdditionalPropertyEmitter $additional = new AdditionalPropertyEmitter(),
        private PropertyEmitter $propertyEmitter = new PropertyEmitter(),
    ) {
        $this->printer = new PsrPrinter();
    }

    /**
     * @param list<string>          $implements       short PHP interface names, defined in $modelNamespace (T-026)
     * @param array<string,string>  $propertyRenames  Profile::$propertyRenames, unsliced — keyed
     *                                                 `'<RawComponentName>.<wirePropertyName>'`. Looked up here as
     *                                                 `"$rawComponentName.$propName"` per property, so a
     *                                                 synthesised model — called with `$rawComponentName = ''`,
     *                                                 which no document component name is — never matches an
     *                                                 entry. Unmatched keys and collisions are the caller's
     *                                                 problem: {@see PropertyRenameValidator}
     *                                                 catches both against the same schema before this runs, so a
     *                                                 rename reaching here is known to name a real property and
     *                                                 land on a name nothing else in the model uses.
     * @param string                 $rawComponentName the raw `components.schemas` key this model came from, or
     *                                                 `''` for a class {@see ModelPlanner}
     *                                                 synthesised itself
     * @param array<string,string>   $phpDocTypes      Profile::$phpDocTypes, unsliced — keyed
     *                                                 `'<RawComponentName>.<wirePropertyName>'` the same way
     *                                                 $propertyRenames is. Looked up per property as
     *                                                 `"$rawComponentName.$wireName"`, so a synthesised model
     *                                                 (`$rawComponentName = ''`) never matches an entry — its
     *                                                 scalar properties still get the constraint-derived
     *                                                 narrowing {@see PhpDocTypeRefiner} computes, only not an
     *                                                 override. {@see PhpDocTypeValidator} rejects a stale key
     *                                                 before this runs.
     */
    public function emit(
        string $modelNamespace,
        string $className,
        Schema $schema,
        Bindings $bindings,
        ?EnumCatalog $enums = null,
        ?NameRegistry $registry = null,
        array $implements = [],
        array $propertyRenames = [],
        string $rawComponentName = '',
        array $phpDocTypes = [],
    ): ModelEmission {
        assert($registry instanceof NameRegistry, 'NameRegistry is required (T-023).');
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
            $names[] = is_int($k) ? (string) $k : $k;
        }
        sort($names, SORT_STRING);

        // Required first (in sorted order), then optional. PHP forbids
        // required-after-optional.
        $ordered = array_merge(
            array_values(array_filter($names, static fn(string $n): bool => in_array($n, $required, true))),
            array_values(array_filter($names, static fn(string $n): bool => !in_array($n, $required, true))),
        );

        /** @var list<SynthesisedModel> $children */
        $children = [];
        /** @var list<string> $phpNames */
        $phpNames = [];
        /** @var list<string> $failures */
        $failures = [];

        foreach ($ordered as $propName) {
            $propSchema = $properties[$propName];
            $isRequired = in_array($propName, $required, true);
            $phpName = $propertyRenames[$rawComponentName . '.' . $propName] ?? self::defaultPropertyName($propName);
            $phpNames[] = $phpName;
            // Keyed by the emitted class name, not $rawComponentName — see
            // Profile::$propertyFormats for why the two diverge.
            $formatScopeKey = $className . '.' . $propName;

            $resolved = $this->properties->resolve(
                $className,
                $phpName,
                $propSchema,
                $children,
                $modelNamespace,
                $bindings,
                $registry,
                $enums,
                $formatScopeKey,
            );

            // Two separate facts, and conflating them mis-orders the
            // constructor. A property may be required *and* nullable — the
            // caller has to pass it and may pass null — so the type admits null
            // while the parameter takes no default. Only an optional property
            // gets a default, which is what keeps every defaulted parameter
            // after every non-defaulted one.
            $failures = [...$failures, ...$this->propertyEmitter->add(
                $namespace,
                $constructor,
                $propName,
                $phpName,
                $resolved,
                !$isRequired || $resolved->nullable,
                !$isRequired,
                $propSchema,
                $bindings,
                $modelNamespace,
                $registry,
                $rawComponentName . '.' . $propName,
                $phpDocTypes[$rawComponentName . '.' . $propName] ?? null,
                $formatScopeKey,
            )];
        }

        // Whatever the schema allowed beyond the declared properties, typed
        // and carried rather than dropped (declared-shapes-become-types).
        $this->additional->apply($namespace, $constructor, $schema, $phpNames, $bindings, $modelNamespace, $registry, $enums);

        $failures = [...$failures, ...PropertyFormatKeys::staleEntries($bindings, $className, $ordered)];

        return new ModelEmission($this->printer->printFile($file), $children, $failures);
    }

    /**
     * The property name poagen would emit for a raw wire name with no
     * `Profile::$propertyRenames` entry — a valid PHP identifier verbatim,
     * or a `camelCase` derivation for one that is not. Public and static so
     * {@see PropertyRenameValidator} can
     * compute the same collision surface a real emission would produce,
     * without a second copy of the derivation to keep in step.
     */
    public static function defaultPropertyName(string $openApiName): string
    {
        if (preg_match('/^[a-zA-Z_]\w*$/', $openApiName) === 1) {
            return $openApiName;
        }
        $parts = preg_split('/[^a-zA-Z0-9]+/', $openApiName);
        if ($parts === false || $parts === []) {
            return 'value';
        }
        $head = strtolower($parts[0]);
        $tail = array_map(static fn(string $p): string => ucfirst(strtolower($p)), array_slice($parts, 1));
        $name = $head . implode('', $tail);

        // `'1'`, `'-'`, etc. still yield an invalid PHP identifier — prefix `_`.
        return ($name === '' || preg_match('/^\d/', $name) === 1) ? '_' . $name : $name;
    }
}
