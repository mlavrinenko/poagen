<?php

/**
 * This file is part of mlavrinenko/paogen
 *
 * @copyright Copyright (c) Maxim Lavrinenko <maxim@lavrinenko.xyz>
 * @license https://opensource.org/license/mit/ MIT License
 */

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Enum;

use cebe\openapi\spec\Schema;

/**
 * Tracks the enum classes the generator plans to emit.
 *
 * Two populate paths:
 *   - `registerComponent()` — called for every named enum component
 *     discovered in `components.schemas`. Used by the TypeResolver to
 *     resolve `$ref` → `\<EnumNamespace>\<Name>`.
 *   - `synthesize()` — called by the OperationEmitter when it finds an
 *     inline enum on a parameter. Synthesises a name from the
 *     surrounding operationId + parameter name.
 *
 * A single catalog is populated across emission so enum files can be
 * written in one final pass at the end of the run.
 */
final class EnumCatalog
{
    /** @var array<string, EnumSpec> $components Keyed by OpenAPI component name. */
    private array $components = [];

    /** @var array<string, EnumSpec> $synthesized Keyed by synthesised PHP name. */
    private array $synthesized = [];

    public function __construct(public readonly string $enumNamespace) {}

    public function registerComponent(string $componentName, EnumSpec $spec): void
    {
        $this->components[$componentName] = $spec;
    }

    /**
     * Synthesise a uniquely-named enum for an inline schema. Returns the
     * generated PHP class name (without namespace). Repeated calls for
     * the same `$preferredName` with an equal-by-value spec are
     * idempotent; conflicting specs are rejected.
     */
    public function synthesize(string $preferredName, EnumSpec $spec): string
    {
        if (isset($this->synthesized[$preferredName])) {
            $existing = $this->synthesized[$preferredName];
            if ($existing->cases !== $spec->cases || $existing->backingType !== $spec->backingType) {
                throw new \RuntimeException(\sprintf(
                    'Synthesised enum name collision: %s already mapped to different values.',
                    $preferredName,
                ));
            }
            return $preferredName;
        }

        $this->synthesized[$preferredName] = $spec;

        return $preferredName;
    }

    public function isEnumComponent(string $componentName): bool
    {
        return isset($this->components[$componentName]);
    }

    public function componentFqcn(string $componentName): ?string
    {
        if (!isset($this->components[$componentName])) {
            return null;
        }

        return '\\' . trim($this->enumNamespace, '\\') . '\\' . $this->components[$componentName]->name;
    }

    public function synthesizedFqcn(string $name): string
    {
        return '\\' . trim($this->enumNamespace, '\\') . '\\' . $name;
    }

    /**
     * @return array<string, EnumSpec> All enum specs keyed by PHP class name.
     */
    public function all(): array
    {
        $out = [];

        foreach ($this->components as $spec) {
            $out[$spec->name] = $spec;
        }

        foreach ($this->synthesized as $spec) {
            $out[$spec->name] = $spec;
        }

        return $out;
    }

    /**
     * Tentatively read an inline schema to build an EnumSpec. Returns null
     * when the schema does not look like a backed enum we can emit.
     */
    public static function specFromSchema(string $name, Schema $schema): ?EnumSpec
    {
        /** @var list<mixed> $enum */
        $enum = $schema->enum ?? [];

        if ($enum === []) {
            return null;
        }

        $backing = match ($schema->type) {
            'string' => EnumSpec::BACKING_STRING,
            'integer' => EnumSpec::BACKING_INT,
            default => null,
        };

        if ($backing === null) {
            return null;
        }

        $cases = [];
        $seenNames = [];

        foreach ($enum as $value) {
            if (!\is_string($value) && !\is_int($value)) {
                return null;
            }

            $caseName = self::pascalize((string) $value);

            if ($caseName === '' || isset($seenNames[$caseName])) {
                // Fall back to a positional suffix to avoid a collision.
                $caseName = $caseName === '' ? 'Case' . (\count($cases) + 1) : $caseName . (\count($cases) + 1);
            }

            $seenNames[$caseName] = true;
            $cases[] = ['name' => $caseName, 'value' => $value];
        }

        return new EnumSpec($name, $backing, $cases);
    }

    public static function pascalize(string $value): string
    {
        // Insert a separator at every lowercase→uppercase transition so that
        // already-camelCased input (findPetsByStatus) splits cleanly into
        // words before the normal split-and-recapitalise pass.
        $withBoundaries = (string) preg_replace('/([a-z0-9])([A-Z])/', '$1_$2', $value);
        $parts = preg_split('/[^a-zA-Z0-9]+/', $withBoundaries);

        if ($parts === false || $parts === []) {
            return '';
        }

        $out = '';

        foreach ($parts as $part) {
            if ($part === '') {
                continue;
            }
            $out .= ucfirst(strtolower($part));
        }

        if ($out === '') {
            return '';
        }

        if (preg_match('/^\d/', $out) === 1) {
            return '_' . $out;
        }

        return $out;
    }
}
