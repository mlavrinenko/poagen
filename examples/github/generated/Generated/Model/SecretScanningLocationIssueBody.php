<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class SecretScanningLocationIssueBody implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['issue_body_url' => ['issue_body_url', null], 'html_url' => ['html_url', null]];

    public function __construct(
        public string $issue_body_url,
        public ?string $html_url = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'issue_body_url' => $this->issue_body_url,
            'html_url' => $this->html_url,
        ];
    }
}
