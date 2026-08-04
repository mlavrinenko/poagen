<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use Nette\PhpGenerator\ClassType;

/**
 * Puts one `public const string` per resolved server on the root client —
 * the constant a consumer reads instead of retyping the document's base
 * address by hand.
 *
 * These are values, not wiring: nothing here touches
 * {@see ClientConstructor}, and the transport still takes its base address
 * as a plain constructor argument, so it stays swappable for a test server
 * or a staging host. A constant on the client only saves the consumer from
 * looking the value up in the schema.
 *
 * @internal
 */
final readonly class ServerConstantEmitter
{
    /**
     * @param list<ResolvedServer> $servers in declaration order — the order
     *                                      {@see ServerCatalog::resolve} produced
     */
    public static function addTo(ClassType $class, array $servers): void
    {
        foreach ($servers as $server) {
            $constant = $class->addConstant($server->constantName, $server->url)
                ->setPublic()
                ->setType('string');

            if ($server->description !== null) {
                $constant->addComment($server->description);
            }
        }
    }
}
