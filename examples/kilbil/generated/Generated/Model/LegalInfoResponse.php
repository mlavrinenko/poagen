<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class LegalInfoResponse
{
    public function __construct(
        public string $agreement_url,
        public string $personal_data_policy_url,
        public string $program_rules_url,
    ) {
    }
}
