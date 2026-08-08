<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator;

use function sprintf;
use function strrpos;
use function substr;

/**
 * Cross-checks `Profile::$propertyFormats` against every model this run
 * actually emits — the whole-run half {@see Emit\PropertyFormatKeys} cannot
 * cover from inside a single model's own emission.
 *
 * `$propertyFormats` keys on the emitted PHP class name rather than a raw
 * `components.schemas` name (see that field's own docblock for why), so
 * there is no document to check a key against the way
 * {@see ComponentPropertyNames} lets {@see PropertyRenameValidator} and
 * {@see PhpDocTypeValidator} check theirs — a synthesised model's name only
 * exists once {@see Emit\ModelEmitter} has already produced it.
 * {@see Emit\ModelNameLedger} is where every name this run ever claims
 * already collects, named component or synthesised, so this validator reads
 * that instead of a document: a key whose model prefix names nothing the
 * ledger claimed is refused the same way a stale `$propertyRenames` entry
 * is, naming the model. A key whose model prefix *is* claimed is left to
 * {@see Emit\PropertyFormatKeys}, which already ran inside that model's own
 * emission and knows whether the property itself is real
 * (bind-a-format-per-property).
 *
 * Returns failure lines rather than throwing, so a run reports every
 * problem it found in one pass, same as every other profile-guidance
 * validator here (abort-on-unrepresentable-constructs).
 */
final readonly class PropertyFormatValidator
{
    /**
     * @param  array<string,string> $propertyFormats Profile::$propertyFormats
     * @param  array<string,true>   $claimedNames    Emit\ModelNameLedger::claimedNames(), read after
     *                                               the whole plan has run
     * @return list<string>         failure lines; empty means every key names a model this run emits
     */
    public function validate(array $propertyFormats, array $claimedNames): array
    {
        $failures = [];

        foreach (array_keys($propertyFormats) as $key) {
            $split = strrpos($key, '.');

            if ($split === false) {
                $failures[] = sprintf(
                    "Profile::\$propertyFormats['%s'] is not '<ModelClassName>.<wirePropertyName>' — add the "
                        . 'missing dot.',
                    $key,
                );

                continue;
            }

            $className = substr($key, 0, $split);

            if (!isset($claimedNames[$className])) {
                $failures[] = sprintf(
                    "Profile::\$propertyFormats['%s'] names a model '%s' this run does not emit — remove this "
                        . 'entry, or point it at the class name poagen actually assigns there.',
                    $key,
                    $className,
                );
            }
        }

        return $failures;
    }
}
