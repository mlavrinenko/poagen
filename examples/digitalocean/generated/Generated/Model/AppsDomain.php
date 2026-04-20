<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\AppsDomainPhase;
use DateTimeImmutable;

final readonly class AppsDomain
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppDomainValidation> $validations
     */
    public function __construct(
        public ?DateTimeImmutable $certificate_expires_at = null,
        public ?string $id = null,
        public ?AppsDomainPhase $phase = null,
        public ?AppsDomainProgress $progress = null,
        public ?bool $rotate_validation_records = null,
        public ?AppDomainSpec $spec = null,
        public ?array $validations = null,
    ) {
    }
}
