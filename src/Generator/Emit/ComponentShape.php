<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;

/**
 * Classification of a top-level `components.schemas` entry (T-026).
 *
 * The generator used to only emit Models for `type: object`; every other
 * shape compiled silently into a `$ref` pointing at a class that never
 * existed. This shape drives a per-kind emitter so every named component
 * ends up as a real PHP class / interface.
 */
final readonly class ComponentShape
{
    public const string KIND_OBJECT = 'object';
    public const string KIND_ALLOF_OBJECT = 'allof_object';
    public const string KIND_ENUM = 'enum';
    public const string KIND_SCALAR = 'scalar';
    public const string KIND_ARRAY = 'array';
    public const string KIND_UNION = 'union';
    public const string KIND_UNSUPPORTED = 'unsupported';

    /**
     * @param 'string'|'integer'|'number'|'boolean'|null $scalarType    populated when KIND_SCALAR
     * @param Schema|null                                $arrayItems    populated when KIND_ARRAY
     * @param list<Schema|Reference>  $unionBranches populated when KIND_UNION
     */
    public function __construct(
        public string $kind,
        public string $phpName,
        public ?string $scalarType = null,
        public ?Schema $arrayItems = null,
        public array $unionBranches = [],
        public ?Schema $schema = null,
        public string $reason = '',
    ) {}
}
