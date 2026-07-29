<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Exception;

/**
 * Thrown when two different schema nodes claim the same emitted model class
 * name.
 *
 * A synthesised name is derived, not declared, so nothing in the document
 * prevents two derivations from meeting. Against a schema with no named
 * components every model is synthesised — roughly a hundred of them for the
 * kilbil loyalty document — which makes the derivation load-bearing rather
 * than cosmetic.
 *
 * Without this the second claim would simply overwrite the first entry in the
 * write map: one file on disk, two schema shapes believing it describes them,
 * and a run that reports success. That is the silent failure
 * `silence-means-success` exists to forbid, so a collision stops the run and
 * names both origins.
 */
final class ModelNameCollisionException extends \RuntimeException
{
    public static function between(string $phpName, string $firstOrigin, string $secondOrigin): self
    {
        return new self(\sprintf(
            "Model name collision: `%s` is claimed by two different schema nodes:\n"
                . "  - %s\n"
                . "  - %s\n"
                . 'Pin one of them to a different class name from the profile — `Profile::$inlineModels` keys a '
                . "synthesised payload on '<operationId>.request' or '<operationId>.response', and "
                . '`Profile::$renames` keys a named component on its schema name.',
            $phpName,
            $firstOrigin,
            $secondOrigin,
        ));
    }
}
