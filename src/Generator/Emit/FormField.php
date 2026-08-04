<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;

/**
 * One property of a form-urlencoded body, emitted as one method parameter.
 *
 * Pure data holder used by {@see BodySpec::form()} so the emitter can
 * decide the PHP type via {@see TypeResolver::resolve()} and honour the
 * required-ness expressed in the operation's request-body schema.
 *
 * @internal
 */
final readonly class FormField
{
    public function __construct(
        public string $name,
        public Schema|Reference $schema,
        public bool $required,
    ) {}
}
