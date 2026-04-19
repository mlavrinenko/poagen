<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class SecretScanningLocationIssueTitle implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['issue_title_url' => ['issue_title_url', null], 'html_url' => ['html_url', null]];

    public function __construct(
        public string $issue_title_url,
        public ?string $html_url = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'issue_title_url' => $this->issue_title_url,
            'html_url' => $this->html_url,
        ];
    }
}
