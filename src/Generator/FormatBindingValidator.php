<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator;

use Poagen\Runtime\Codec;
use Poagen\Runtime\ScalarBinding;

use function class_exists;
use function is_a;
use function sprintf;

/**
 * Checks every `Profile::$formats` entry names a class that exists and opts
 * into one of the two contracts a format binding can satisfy.
 *
 * The check runs before the document is read, which none of the other
 * guidance validators here can manage. `$propertyRenames`, `$phpDocTypes` and
 * `$skip` key on something the document has to be consulted about, and
 * `$propertyFormats` keys on a model name that only exists once emission has
 * named it ({@see PropertyFormatValidator} is the half that waits for the
 * whole plan to run). A `$formats` key is a bare format string with no target
 * to be stale against — the entry either names a usable binding or it does
 * not, and both halves of that are answerable from the class alone.
 *
 * Both halves are checked, not just existence. A class that exists but
 * implements neither {@see ScalarBinding} nor {@see Codec} would otherwise
 * reach {@see Bindings::scalarFormat()}, which reads it as a deliberate
 * whole-object binding and quietly leaves the scalar path — so the property
 * would emit as an object the payload never carries, with nothing said. That
 * is the silent-degradation shape `default-deny-on-degradation` refuses, and
 * it is why both interfaces are named in the failure line rather than only
 * implied.
 *
 * Returns failure lines rather than throwing, so a run reports every problem
 * it found in one pass, same as every other profile-guidance validator here
 * (abort-on-unrepresentable-constructs).
 */
final readonly class FormatBindingValidator
{
    /**
     * @param  array<string,string> $formats Profile::$formats
     * @return list<string>         failure lines; empty means every entry names a usable binding
     */
    public function validate(array $formats): array
    {
        $failures = [];

        foreach ($formats as $format => $fqcn) {
            if (!class_exists($fqcn)) {
                $failures[] = sprintf(
                    "Profile::\$formats['%s'] names a class '%s' that does not exist — check the namespace "
                        . 'and spelling.',
                    $format,
                    $fqcn,
                );

                continue;
            }

            if (!is_a($fqcn, ScalarBinding::class, true) && !is_a($fqcn, Codec::class, true)) {
                $failures[] = sprintf(
                    "Profile::\$formats['%s'] names '%s', which does not implement %s or %s — a format binding "
                        . 'round-trips as the underlying scalar, itself or through a codec, so the class has to '
                        . 'declare how.',
                    $format,
                    $fqcn,
                    ScalarBinding::class,
                    Codec::class,
                );
            }
        }

        return $failures;
    }
}
