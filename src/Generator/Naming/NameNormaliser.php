<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Naming;

/**
 * Strategy that maps an OpenAPI symbol's raw name to a PHP identifier.
 *
 * See `typed-profile-and-colocated-attributes` ("Name normalisation —
 * `nameNormaliser`") for the pipeline and precedence model. T-023.
 */
interface NameNormaliser
{
    /**
     * @return string|null PHP identifier when this strategy handles
     *                    the input; null to pass through to the next.
     */
    public function normalise(string $raw, NormalisationContext $context): ?string;
}
