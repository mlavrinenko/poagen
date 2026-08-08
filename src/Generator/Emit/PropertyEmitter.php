<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpNamespace;
use Poagen\Generator\Generator\Bindings;
use Poagen\Generator\Generator\Naming\NameRegistry;

use function str_contains;
use function str_ends_with;

/**
 * Adds one promoted constructor parameter for a single declared property:
 * its PHP type — split between `?T` and a `|null`-suffixed union per the
 * comment on {@see self::add()} — its `@param` doc line (via
 * {@see PropertyDocType}), the use-imports its type needs, and its wire
 * attributes (via {@see ModelAttributeApplier}).
 *
 * Split out of {@see ModelEmitter}; the two together had outgrown what
 * linecop allows a generator file to be (`quality-gates-at-maximum-strictness`).
 *
 * @internal
 */
final readonly class PropertyEmitter
{
    public function __construct(
        private ModelAttributeApplier $attributes = new ModelAttributeApplier(),
    ) {}

    /**
     * @return list<string> the profile guidance this property could not honour, refused rather than dropped
     */
    public function add(
        PhpNamespace $namespace,
        Method $constructor,
        string $wireName,
        string $phpName,
        TypeResolver $resolved,
        bool $isNullable,
        bool $hasDefault,
        Schema|Reference $propSchema,
        Bindings $bindings,
        string $modelNamespace,
        NameRegistry $registry,
        string $docTypeKey = '',
        ?string $docTypeOverride = null,
    ): array {
        $type = $resolved->phpType;
        $param = $constructor->addPromotedParameter($phpName)->setPublic();

        // `?T` is only spellable for a single type. `mixed` already admits null,
        // and a union has to carry `|null` inside the type string — `?Dog|Cat`
        // is not PHP. Either way an optional property defaults to null so the
        // caller may omit it.
        $spellsOwnNull = $type === 'mixed' || ($type !== null && str_contains($type, '|'));

        if ($type !== null) {
            $param->setType(
                $isNullable && $spellsOwnNull && $type !== 'mixed' && !str_ends_with($type, '|null')
                    ? $type . '|null'
                    : $type,
            );
        }
        if ($isNullable && !$spellsOwnNull) {
            $param->setNullable();
        }
        if ($hasDefault) {
            $param->setDefaultValue(null);
        }
        // Which of the three doc-type sources wins this property's slot, and
        // whether an override that cannot reach it fails the run — see
        // PropertyDocType.
        $doc = PropertyDocType::of($namespace, $resolved, $propSchema, $docTypeKey, $docTypeOverride, $isNullable, $phpName);

        if ($doc->comment !== null) {
            $constructor->addComment($doc->comment);
        }

        // Hint use-statements for FQNs so the printed file uses short forms.
        foreach ($type !== null ? explode('|', $type) : [] as $part) {
            if (str_contains($part, '\\')) {
                $namespace->addUse(ltrim($part, '\\'));
            }
        }
        if ($resolved->phpDocUse !== null) {
            $namespace->addUse(ltrim($resolved->phpDocUse, '\\'));
        }

        $this->attributes->apply($namespace, $param, $wireName, $phpName, $propSchema, $bindings, $modelNamespace, $registry);

        return $doc->failure !== null ? [$doc->failure] : [];
    }
}
