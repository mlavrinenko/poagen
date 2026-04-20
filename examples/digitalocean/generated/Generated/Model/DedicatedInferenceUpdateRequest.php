<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DedicatedInferenceUpdateRequest
{
    public function __construct(
        public ?DedicatedInferenceUpdateRequestAccess_tokens $access_tokens = null,
        public ?DedicatedInferenceSpec $spec = null,
    ) {
    }
}
