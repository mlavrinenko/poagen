<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\json\JsonPointer;
use cebe\openapi\spec\Schema;

/**
 * An inline schema node promoted to a named generated class.
 *
 * Three producers queue these, and the FIFO in
 * {@see \Mlavrinenko\Paogen\Generator\ModelPlanner} drains them all the same
 * way, re-running the emitter against each entry so it may queue grandchildren:
 *
 *   - {@see ModelEmitter} for a property whose schema is an inline object with
 *     declared properties — with or without the `type` keyword beside them,
 *     see {@see ObjectShape} — or an array of such (T-013);
 *   - {@see ModelPlanner} for an inline `oneOf` / `anyOf` branch (T-026);
 *   - {@see InlinePayloadPlanner} for an operation's inline request or
 *     response payload (inline-body-and-response-schemas).
 */
final readonly class SynthesisedModel
{
    /**
     * @param string       $name       emitted PHP class name, without namespace
     * @param Schema       $schema     the inline node this class describes
     * @param list<string> $implements short interface PHP names in the same
     *                                 model namespace; T-026 synthesises
     *                                 `oneOf`/`anyOf` branch classes that
     *                                 must `implements <Union>`
     * @param string       $origin     where the node sits, for a collision diagnostic
     *                                 via {@see ModelNameLedger}; a JSON pointer when
     *                                 the document supplied a document position
     */
    public function __construct(
        public string $name,
        public Schema $schema,
        public array $implements = [],
        public string $origin = '',
    ) {}

    /**
     * Derive the origin from the node's own document position, so a collision
     * diagnostic points at the schema rather than at the class name paogen
     * chose for it.
     *
     * @param list<string> $implements
     */
    public static function forNode(string $name, Schema $schema, array $implements = []): self
    {
        return new self($name, $schema, $implements, self::originOf($schema));
    }

    public static function originOf(Schema $schema): string
    {
        $pointer = $schema->getDocumentPosition();

        return $pointer instanceof JsonPointer ? $pointer->getPointer() : '(no document position)';
    }
}
