<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookSecurityAndAnalysisChangesFrom implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'security_and_analysis' => ['security_and_analysis', \Acme\GitHub\Generated\Model\SecurityAndAnalysis::class],
    ];

    public function __construct(
        public ?SecurityAndAnalysis $security_and_analysis = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'security_and_analysis' => $this->security_and_analysis,
        ];
    }
}
