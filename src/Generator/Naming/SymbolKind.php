<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Naming;

/**
 * The kind of OpenAPI symbol whose name is being normalised.
 *
 * `SchemaComponent` flows through the global registry shared across the
 * generated Model tree. `OperationId` flows through a sibling registry
 * scoped to the ApiClient (collisions there clash on the *class*).
 * `ParameterName` is scoped per-operation: collisions matter only
 * within a single PHP method signature, so the emitter spins a fresh
 * registry per operation.
 */
enum SymbolKind
{
    case SchemaComponent;
    case OperationId;
    case ParameterName;
}
