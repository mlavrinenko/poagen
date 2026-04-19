<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CodeScanningSarifsReceipt implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'id' => ['id', \Acme\GitHub\Generated\Model\CodeScanningAnalysisSarifId::class],
        'url' => ['url', null],
    ];

    public function __construct(
        public ?CodeScanningAnalysisSarifId $id = null,
        public ?string $url = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'url' => $this->url,
        ];
    }
}
