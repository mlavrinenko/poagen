<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Enum;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Mlavrinenko\Paogen\Generator\Naming\NameRegistry;
use Mlavrinenko\Paogen\Generator\Naming\NormalisationContext;
use Mlavrinenko\Paogen\Generator\Naming\SymbolKind;

/**
 * Registers every named `components.schemas` entry that is a backed enum, so a
 * `$ref` to it resolves to an enum class rather than to its base type.
 *
 * Runs before anything else in the pipeline, because the component catalogue
 * classifies a schema by asking the catalog whether it already knows it as an
 * enum.
 *
 * @internal
 */
final readonly class ComponentEnumCollector
{
    public function collect(OpenApi $openApi, EnumCatalog $enums, NameRegistry $registry): void
    {
        $components = $openApi->components;

        if ($components === null) {
            return;
        }

        /** @var array<string,Schema|Reference> $schemas */
        $schemas = $components->schemas ?? [];
        $context = new NormalisationContext(SymbolKind::SchemaComponent);

        foreach ($schemas as $name => $schema) {
            if (!$schema instanceof Schema) {
                continue;
            }

            $rawSpec = EnumCatalog::specFromSchema($name, $schema);

            if (!$rawSpec instanceof EnumSpec) {
                continue;
            }

            $phpName = $registry->resolve($name, $context);
            $enums->registerComponent($name, new EnumSpec($phpName, $rawSpec->backingType, $rawSpec->cases));
        }
    }
}
