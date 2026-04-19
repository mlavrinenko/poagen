<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\AppsDomainPhase;
use DateTimeImmutable;
use JsonSerializable;

final readonly class AppsDomain implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'certificate_expires_at' => ['certificate_expires_at', ['datetime', null]],
        'id' => ['id', null],
        'phase' => ['phase', ['enum', \Acme\DigitalOcean\Generated\Enum\AppsDomainPhase::class]],
        'progress' => ['progress', \Acme\DigitalOcean\Generated\Model\AppsDomainProgress::class],
        'rotate_validation_records' => ['rotate_validation_records', null],
        'spec' => ['spec', \Acme\DigitalOcean\Generated\Model\AppDomainSpec::class],
        'validations' => ['validations', ['list', \Acme\DigitalOcean\Generated\Model\AppDomainValidation::class]],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'certificate_expires_at' => $this->certificate_expires_at?->format(\DateTimeInterface::RFC3339),
            'id' => $this->id,
            'phase' => $this->phase,
            'progress' => $this->progress,
            'rotate_validation_records' => $this->rotate_validation_records,
            'spec' => $this->spec,
            'validations' => $this->validations,
        ];
    }
}
