<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Naming;

/**
 * The kind of OpenAPI symbol whose name is being normalised. Today
 * only schema components flow through the pipeline; enum cases and
 * operation IDs follow if a fixture surfaces a need.
 */
enum SymbolKind
{
    case SchemaComponent;
}
