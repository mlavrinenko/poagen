<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class RepositoryRuleCodeScanningParameters implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'code_scanning_tools' => [
            'code_scanning_tools',
            ['list', \Acme\GitHub\Generated\Model\RepositoryRuleParamsCodeScanningTool::class],
        ],
    ];

    /**
     * @param list<\Acme\GitHub\Generated\Model\RepositoryRuleParamsCodeScanningTool> $code_scanning_tools
     */
    public function __construct(
        public array $code_scanning_tools,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'code_scanning_tools' => $this->code_scanning_tools,
        ];
    }
}
