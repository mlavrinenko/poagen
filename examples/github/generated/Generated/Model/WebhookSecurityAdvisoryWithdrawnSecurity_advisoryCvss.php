<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookSecurityAdvisoryWithdrawnSecurity_advisoryCvss
{
    public function __construct(
        public float $score,
        public ?string $vector_string = null,
    ) {
    }
}
