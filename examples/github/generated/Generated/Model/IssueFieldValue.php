<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class IssueFieldValue implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'data_type' => ['data_type', null],
        'issue_field_id' => ['issue_field_id', null],
        'node_id' => ['node_id', null],
        'value' => ['value', null],
        'single_select_option' => [
            'single_select_option',
            \Acme\GitHub\Generated\Model\IssueFieldValueSingle_select_option::class,
        ],
    ];

    /**
     * @param ?mixed $value
     */
    public function __construct(
        public string $data_type,
        public int $issue_field_id,
        public string $node_id,
        public $value = null,
        public ?IssueFieldValueSingle_select_option $single_select_option = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'data_type' => $this->data_type,
            'issue_field_id' => $this->issue_field_id,
            'node_id' => $this->node_id,
            'value' => $this->value,
            'single_select_option' => $this->single_select_option,
        ];
    }
}
