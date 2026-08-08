<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use Poagen\Generator\Generator\Bindings;

use function class_exists;
use function in_array;
use function sprintf;
use function str_starts_with;
use function strlen;
use function substr;

/**
 * Cross-checks `Profile::$propertyFormats` entries scoped to one
 * already-emitted model against what that model actually declares — the
 * per-model half of that field's stale-key check
 * (bind-a-format-per-property). `PropertyFormatValidator` is the other
 * half, for a key whose model this run never emits at all.
 *
 * Keyed by the emitted class name rather than a raw document component name,
 * unlike `Profile::$propertyRenames` / `$phpDocTypes` and their validators —
 * see that field's own docblock for why. There is consequently no
 * pre-emission document to check this against the way
 * `ComponentPropertyNames` lets those two validators check theirs: a
 * synthesised model's name only exists once this class has already produced
 * it, which is why this runs per emitted model instead, from inside
 * {@see ModelEmitter}, catching a key naming a real property poagen renamed
 * or dropped since the profile was written. Its failures reach the run's
 * final report through the ordinary `ModelEmission::$failures` channel for
 * a named component and, since `queue-drained-models-swallow-emission-failures`
 * closed, through {@see SynthesisQueueDrain}'s own `$failures` parameter for
 * a synthesised one too.
 *
 * @internal
 */
final readonly class PropertyFormatKeys
{
    /**
     * @param  list<string> $declaredWireNames every wire property $className actually declares
     * @return list<string> failure lines scoped to this one model; empty means every entry
     *                      naming $className matched a real property and an existing class
     */
    public static function staleEntries(Bindings $bindings, string $className, array $declaredWireNames): array
    {
        $prefix = $className . '.';
        $failures = [];

        foreach ($bindings->propertyFormats as $key => $fqcn) {
            if (!str_starts_with($key, $prefix)) {
                continue;
            }

            $wireProp = substr($key, strlen($prefix));

            if (!in_array($wireProp, $declaredWireNames, true)) {
                $failures[] = sprintf(
                    "Profile::\$propertyFormats['%s'] names a property absent from model '%s' — remove this "
                        . 'entry, or point it at the property poagen actually emits there.',
                    $key,
                    $className,
                );

                continue;
            }

            if (!class_exists($fqcn)) {
                $failures[] = sprintf(
                    "Profile::\$propertyFormats['%s'] names a class '%s' that does not exist — check the "
                        . 'namespace and spelling.',
                    $key,
                    $fqcn,
                );
            }
        }

        return $failures;
    }
}
