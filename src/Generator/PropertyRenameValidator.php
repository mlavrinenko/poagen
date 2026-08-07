<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator;

use cebe\openapi\spec\OpenApi;
use Poagen\Generator\Generator\Emit\ModelEmitter;

use function in_array;
use function sprintf;
use function strrpos;
use function substr;

/**
 * Cross-checks `Profile::$propertyRenames` against the document.
 *
 * Same discipline as {@see ProfileTargetValidator} and {@see SkipListValidator},
 * applied one level below where those two stop: a rename is keyed
 * `'<RawComponentName>.<wirePropertyName>'`, so a key can go stale in two
 * independent ways — the component itself vanishes, or the component stays
 * but drops the property — and both look like working guidance until the
 * schema moves. Consistency with `$inlineModels` and `$tagChoice` is the
 * point, not a stylistic choice: guidance that outlives its target is worse
 * than no guidance, because nothing else surfaces it.
 *
 * A rename landing on a name another property in the same model already
 * uses — renamed or not — is a second, independent failure this also
 * catches: two constructor parameters cannot share a name, and
 * nette/php-generator does not detect the clash itself (it just lets the
 * second silently overwrite the first in its internal parameter map).
 *
 * Returns failure lines rather than throwing, so a run reports every problem
 * it found in one pass, same as every other profile-guidance validator here
 * (abort-on-unrepresentable-constructs).
 */
final readonly class PropertyRenameValidator
{
    /**
     * @param  array<string,string> $propertyRenames Profile::$propertyRenames
     * @return list<string>         failure lines; empty means the run may proceed
     */
    public function validate(OpenApi $openApi, Emit\ComponentCatalog $components, array $propertyRenames): array
    {
        $failures = [];
        /** @var array<string, array<string,string>> $byComponent wire property name → desired PHP name */
        $byComponent = [];

        foreach ($propertyRenames as $key => $desired) {
            $split = strrpos($key, '.');

            if ($split === false) {
                $failures[] = sprintf(
                    "Profile::\$propertyRenames['%s'] is not '<RawComponentName>.<wirePropertyName>' — add the "
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
                    "Profile::\$propertyRenames['%s'] names a component absent from the document — remove this "
                        . 'entry, or point it at the component the vendor now uses.',
                    $key,
                );

                continue;
            }

            if (!in_array($wireProp, $properties, true)) {
                $failures[] = sprintf(
                    "Profile::\$propertyRenames['%s'] names a property absent from component '%s' — remove this "
                        . 'entry, or point it at the property name the vendor now uses.',
                    $key,
                    $rawName,
                );

                continue;
            }

            $byComponent[$rawName][$wireProp] = $desired;
        }

        foreach ($byComponent as $rawName => $renames) {
            $properties = ComponentPropertyNames::of($openApi, $components, $rawName) ?? [];
            $failures = [...$failures, ...$this->collisions($rawName, $properties, $renames)];
        }

        return $failures;
    }

    /**
     * @param  array<string,string> $renames    wire property name → desired PHP name, for this component only
     * @param  list<string>         $properties every wire property name declared on this component
     * @return list<string>
     */
    private function collisions(string $rawName, array $properties, array $renames): array
    {
        /** @var array<string,string> $claimedBy final PHP name → wire property name that claimed it first */
        $claimedBy = [];
        $failures = [];

        foreach ($properties as $wireProp) {
            $phpName = $renames[$wireProp] ?? ModelEmitter::defaultPropertyName($wireProp);
            $first = $claimedBy[$phpName] ?? null;

            if ($first !== null) {
                $failures[] = sprintf(
                    "Profile::\$propertyRenames renames component '%s' property '%s' to '%s', which is the PHP "
                        . "name property '%s' already uses — pick a different name for one of them.",
                    $rawName,
                    $wireProp,
                    $phpName,
                    $first,
                );

                continue;
            }

            $claimedBy[$phpName] = $wireProp;
        }

        return $failures;
    }
}
