<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class RepositoryRuleParamsCodeScanningTool implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'alerts_threshold' => ['alerts_threshold', null],
        'security_alerts_threshold' => ['security_alerts_threshold', null],
        'tool' => ['tool', null],
    ];

    public function __construct(
        public string $alerts_threshold,
        public string $security_alerts_threshold,
        public string $tool,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'alerts_threshold' => $this->alerts_threshold,
            'security_alerts_threshold' => $this->security_alerts_threshold,
            'tool' => $this->tool,
        ];
    }
}
