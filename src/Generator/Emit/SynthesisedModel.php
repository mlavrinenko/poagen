<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\Schema;

/**
 * A nested inline-object schema promoted to a named generated class.
 *
 * Emitted by {@see ModelEmitter} when it encounters a property whose schema
 * is an inline `type: object` with declared properties (T-013). The owning
 * {@see \Mlavrinenko\Paogen\Generator\Generator} drains the queue and runs
 * the emitter again against each entry, which may itself queue grandchildren.
 */
final readonly class SynthesisedModel
{
    public function __construct(
        public string $name,
        public Schema $schema,
    ) {}
}
