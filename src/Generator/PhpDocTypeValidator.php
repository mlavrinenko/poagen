<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator;

use cebe\openapi\spec\OpenApi;

use function array_keys;
use function in_array;
use function sprintf;
use function strrpos;
use function substr;

/**
 * Cross-checks `Profile::$phpDocTypes` against the document, the same
 * discipline {@see PropertyRenameValidator} applies to `$propertyRenames`
 * one field over — the two share the `'<RawComponentName>.<wirePropertyName>'`
 * key, so they can go stale the same two ways: the component leaves the
 * document, or it stays but drops the property.
 *
 * An override that matches nothing is the failure mode this guards. It reads
 * as a working refinement, it costs nothing to write, and it silently stops
 * applying the moment the vendor renames the property it named — so a
 * consumer's `numeric-string` promise quietly reverts to bare `string` while
 * the profile still claims to make it. Guidance that outlives its target is
 * worse than no guidance, because nothing else surfaces it
 * (abort-on-unrepresentable-constructs).
 *
 * Only the key is judged here. Whether the *value* is one the property can
 * carry is a fact about the resolved PHP type, which does not exist yet at
 * this point in the run — {@see Emit\PhpDocTypeCompatibility} answers that from
 * inside the emission, and its refusals join these in the same one-pass report.
 *
 * Component-and-property existence is resolved through
 * {@see ComponentPropertyNames}, the one place that reading lives, so this
 * validator and {@see PropertyRenameValidator} always agree on what "the
 * model" contains. Returns failure lines rather than throwing, so a run
 * reports every problem it found in one pass.
 */
final readonly class PhpDocTypeValidator
{
    /**
     * @param  array<string,string> $phpDocTypes Profile::$phpDocTypes
     * @return list<string>          failure lines; empty means the run may proceed
     */
    public function validate(OpenApi $openApi, Emit\ComponentCatalog $components, array $phpDocTypes): array
    {
        $failures = [];

        foreach (array_keys($phpDocTypes) as $key) {
            $split = strrpos($key, '.');

            if ($split === false) {
                $failures[] = sprintf(
                    "Profile::\$phpDocTypes['%s'] is not '<RawComponentName>.<wirePropertyName>' — add the "
                        . 'missing dot.',
                    $key,
                );

                continue;
            }

            $rawName = substr($key, 0, $split);
            $wireProp = substr($key, $split + 1);
            $properties = ComponentPropertyNames::of($openApi, $components, $rawName);

            if ($properties === null) {
                $failures[] = sprintf(
                    "Profile::\$phpDocTypes['%s'] names a component absent from the document — remove this "
                        . 'entry, or point it at the component the vendor now uses.',
                    $key,
                );

                continue;
            }

            if (!in_array($wireProp, $properties, true)) {
                $failures[] = sprintf(
                    "Profile::\$phpDocTypes['%s'] names a property absent from component '%s' — remove this "
                        . 'entry, or point it at the property name the vendor now uses.',
                    $key,
                    $rawName,
                );
            }
        }

        return $failures;
    }
}
