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
 *
 * `Tag` names a sub-client class and its interface, so it collides on the
 * emitted class name and flows through a registry of its own. It is the one
 * kind whose raw form is routinely not ASCII — all eleven tags in the kilbil
 * loyalty document are Russian words — which is why the sanitisers fold to
 * ASCII before splitting.
 */
enum SymbolKind
{
    case SchemaComponent;
    case OperationId;
    case ParameterName;
    case Tag;
}
